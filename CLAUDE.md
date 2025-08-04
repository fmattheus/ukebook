# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a fork of the UkeGeeks Scriptasaurus project - a web-based ukulele songbook application for the Munich Ukulele Collective (Mucbook). The application allows users to create, edit, and display ukulele songs with chord diagrams using ChordPro markup format.

## Architecture

**Frontend Stack:**
- Vanilla JavaScript with jQuery (1.9.1)
- ACE Editor for code editing with custom ChordPro syntax highlighting
- Bootstrap Typeahead for autocomplete
- CSS built from LESS source files
- Canvas-based chord diagram rendering

**Backend Stack:**
- PHP with custom MVC-like architecture
- File-based storage (no database) using `.cpm.txt` files
- Simple authentication system with hardcoded accounts
- PDF generation capabilities

**Key Directories:**
- `/cpm/` - ChordPro song files (.cpm.txt format)
- `/ugsphp/` - PHP backend (MVC structure with builders, viewmodels, views)
- `/src/js/` - Source JavaScript files (editor, chord rendering, parsing)
- `/src/less/` - LESS stylesheets
- `/js/`, `/css/` - Compiled/minified assets

## File Formats

- **Songs**: ChordPro format stored as `.cpm.txt` files in `/cpm/` directory
- **Setlists**: JSON format stored in `/cpm/setlists/`
- **Configuration**: PHP class-based config in `ugsphp/Config.php`

## Development Workflow

This project appears to use a manual build process. The compiled JavaScript and CSS files are checked into version control.

**Key Files to Understand:**
- `ugsphp/Config.php` - Main application configuration
- `music.php` - Entry point that bootstraps the PHP application
- `src/js/editor/` - Song editor functionality
- `src/js/scriptasaurus/` - Core chord parsing and rendering

## Song Management

Songs are stored as individual `.cpm.txt` files using ChordPro markup. The application provides:
- Web-based editor with syntax highlighting
- Chord diagram generation and transposition
- Setlist creation and management
- PDF export functionality

## Authentication

Simple file-based authentication system configured in `Config.php`. Users can have view-only or edit permissions.

## Recent Features

Based on git history, recent additions include:
- Setlist import from Google Docs
- Transpose functionality for setlists
- Leader assignments for songs in setlists
- Session-independent URL handling