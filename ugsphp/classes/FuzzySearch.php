<?php

/**
 * Fuzzy Search implementation using FuzzyWuzzy algorithm
 * Based on the Python fuzzywuzzy library algorithm
 * @class FuzzySearch
 */
class FuzzySearch {
    
    /**
     * Calculate the ratio of similarity between two strings
     * @param string $str1
     * @param string $str2
     * @return float Percentage (0-100)
     */
    public static function ratio($str1, $str2) {
        $str1 = self::normalizeString($str1);
        $str2 = self::normalizeString($str2);
        
        if ($str1 === $str2) {
            return 100.0;
        }
        
        if (empty($str1) || empty($str2)) {
            return 0.0;
        }
        
        $levenshtein = levenshtein($str1, $str2);
        $maxLen = max(strlen($str1), strlen($str2));
        
        if ($maxLen === 0) {
            return 100.0;
        }
        
        $ratio = (($maxLen - $levenshtein) / $maxLen) * 100;
        
        // For very high ratios, do additional validation
        if ($ratio > 90) {
            // Check character similarity as a secondary measure
            $similarity = similar_text($str1, $str2, $percent);
            if ($percent < 90) {
                $ratio = min($ratio, $percent); // Use the lower score
            }
        }
        
        return round($ratio, 1);
    }
    
    /**
     * Calculate partial ratio (best partial string matching)
     * @param string $str1
     * @param string $str2
     * @return float Percentage (0-100)
     */
    public static function partialRatio($str1, $str2) {
        $str1 = self::normalizeString($str1);
        $str2 = self::normalizeString($str2);
        
        if ($str1 === $str2) {
            return 100.0;
        }
        
        if (empty($str1) || empty($str2)) {
            return 0.0;
        }
        
        $shorter = strlen($str1) <= strlen($str2) ? $str1 : $str2;
        $longer = strlen($str1) <= strlen($str2) ? $str2 : $str1;
        
        $bestRatio = 0.0;
        $shorterLen = strlen($shorter);
        
        // Try all possible substrings of the shorter string
        for ($i = 0; $i <= strlen($longer) - $shorterLen; $i++) {
            $substring = substr($longer, $i, $shorterLen);
            $ratio = self::ratio($shorter, $substring);
            $bestRatio = max($bestRatio, $ratio);
        }
        
        return $bestRatio;
    }
    
    /**
     * Calculate token sort ratio (sorts tokens before comparing)
     * @param string $str1
     * @param string $str2
     * @return float Percentage (0-100)
     */
    public static function tokenSortRatio($str1, $str2) {
        $str1 = self::normalizeString($str1);
        $str2 = self::normalizeString($str2);
        
        $tokens1 = self::tokenize($str1);
        $tokens2 = self::tokenize($str2);
        
        sort($tokens1);
        sort($tokens2);
        
        $sorted1 = implode(' ', $tokens1);
        $sorted2 = implode(' ', $tokens2);
        
        return self::ratio($sorted1, $sorted2);
    }
    
    /**
     * Calculate token set ratio (uses intersection and remainder)
     * @param string $str1
     * @param string $str2
     * @return float Percentage (0-100)
     */
    public static function tokenSetRatio($str1, $str2) {
        $str1 = self::normalizeString($str1);
        $str2 = self::normalizeString($str2);
        
        $tokens1 = self::tokenize($str1);
        $tokens2 = self::tokenize($str2);
        
        $intersection = array_intersect($tokens1, $tokens2);
        $diff1to2 = array_diff($tokens1, $tokens2);
        $diff2to1 = array_diff($tokens2, $tokens1);
        
        $sortedIntersection = $intersection;
        $sortedDiff1to2 = $diff1to2;
        $sortedDiff2to1 = $diff2to1;
        
        sort($sortedIntersection);
        sort($sortedDiff1to2);
        sort($sortedDiff2to1);
        
        $combined1 = implode(' ', $sortedIntersection) . ' ' . implode(' ', $sortedDiff1to2);
        $combined2 = implode(' ', $sortedIntersection) . ' ' . implode(' ', $sortedDiff2to1);
        
        $ratio1 = self::ratio($combined1, $combined2);
        $ratio2 = self::ratio(implode(' ', $sortedIntersection), implode(' ', $sortedDiff1to2));
        $ratio3 = self::ratio(implode(' ', $sortedIntersection), implode(' ', $sortedDiff2to1));
        
        return max($ratio1, $ratio2, $ratio3);
    }
    
    /**
     * Get the best ratio using all available methods
     * @param string $str1
     * @param string $str2
     * @return float Percentage (0-100)
     */
    public static function bestRatio($str1, $str2) {
        $ratio = self::ratio($str1, $str2);
        $partialRatio = self::partialRatio($str1, $str2);
        $tokenSortRatio = self::tokenSortRatio($str1, $str2);
        $tokenSetRatio = self::tokenSetRatio($str1, $str2);
        
        return max($ratio, $partialRatio, $tokenSortRatio, $tokenSetRatio);
    }
    
    /**
     * Normalize string for better comparison
     * @param string $str
     * @return string
     */
    private static function normalizeString($str) {
        // Convert to lowercase
        $str = strtolower($str);
        
        // Remove common words that don't add meaning
        $commonWords = array('the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by');
        $words = explode(' ', $str);
        $words = array_diff($words, $commonWords);
        
        // Remove punctuation and extra spaces
        $str = preg_replace('/[^\w\s]/', '', implode(' ', $words));
        $str = preg_replace('/\s+/', ' ', $str);
        
        return trim($str);
    }
    
    /**
     * Tokenize string into words
     * @param string $str
     * @return array
     */
    private static function tokenize($str) {
        $words = explode(' ', $str);
        $words = array_filter($words, function($word) {
            return strlen($word) > 0;
        });
        return array_values($words);
    }
    
    /**
     * Search for matches in a list of items
     * @param string $query Either a single string (legacy) or an array with 'title' and 'artist' keys
     * @param array $items Array of objects with 'Title' and 'Artist' properties
     * @param int $limit Maximum number of results
     * @return array Array of matches with scores
     */
    public static function search($query, $items, $limit = 10) {
        // If $query is a string, treat it as a title-only search (legacy)
        if (is_string($query)) {
            $queryTitle = self::normalizeString($query);
            $queryArtist = '';
        } else {
            $queryTitle = self::normalizeString($query['title'] ?? '');
            $queryArtist = self::normalizeString($query['artist'] ?? '');
        }
        $matches = array();
        
        foreach ($items as $item) {
            $title = self::normalizeString($item->Title);
            $artist = self::normalizeString($item->Artist);
            
            $titleScore = $queryTitle ? self::bestRatio($queryTitle, $title) : 0;
            $artistScore = $queryArtist ? self::bestRatio($queryArtist, $artist) : 0;
            
            $combinedScore = 0;
            if ($queryTitle && $queryArtist) {
                // Both fields provided: require both to match well
                if ($titleScore > 60 && $artistScore > 60) {
                    $combinedScore = ($titleScore * 0.7) + ($artistScore * 0.3);
                } else {
                    $combinedScore = min($titleScore, $artistScore) * 0.3;
                }
            } elseif ($queryTitle) {
                $combinedScore = $titleScore;
            } elseif ($queryArtist) {
                $combinedScore = $artistScore;
            }
            
            // Only include if score is above threshold
            if ($combinedScore > 20) {
                $matches[] = array(
                    'item' => $item,
                    'score' => round($combinedScore),
                    'titleScore' => round($titleScore),
                    'artistScore' => round($artistScore)
                );
            }
        }
        
        // Sort by score (highest first)
        usort($matches, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Return top matches
        return array_slice($matches, 0, $limit);
    }
} 