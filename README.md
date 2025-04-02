# LFI Practice Game

A Local File Inclusion (LFI) practice game designed to help learn about PHP file inclusion vulnerabilities and security.

## Prerequisites

- PHP 7.0 or higher
- Python 3.6 or higher
- Web browser

## Setup

1. Clone or download this repository
2. Navigate to the `lfi_game` directory
3. Run the Python launcher:
   ```bash
   python launch.py
   ```
4. The game will open in your default browser at http://localhost:5555

## Game Structure

### Practice Section (index.php)
Contains 5 practice flags to learn basic LFI techniques:
- Flag 1: Basic file inclusion
- Flag 2: Directory traversal
- Flag 3: PHP wrapper usage
- Flag 4: Configuration file access
- Flag 5: Hidden directory access

### Challenge Section (game/playgame.php)
Contains 3 challenging levels:
- Level 1: Basic LFI challenge
- Level 2: PHP wrapper challenge
- Level 3: Advanced bypass techniques

## Learning Objectives

1. Understanding Local File Inclusion vulnerabilities
2. Learning about PHP wrappers and their usage
3. Practicing file inclusion techniques
4. Understanding security measures and bypasses

## Security Note

This game is designed for educational purposes only. Do not use these techniques on systems you don't own or have permission to test.

## Flags

### Practice Flags
- Flag 1: CTF{LFI_Welcome_Flag_123}
- Flag 2: CTF{LFI_About_Flag_456}
- Flag 3: Use php://filter to find
- Flag 4: CTF{LFI_Config_Flag_789}
- Flag 5: CTF{LFI_Hidden_Dir_Flag_101}

### Game Flags
- Game Flag 1: CTF{LFI_Game_Level1_Flag}
- Game Flag 2: CTF{LFI_Game_Level2_Flag}
- Game Flag 3: CTF{LFI_Game_Level3_Flag}
