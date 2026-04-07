#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import json
import re
from pathlib import Path

# Load dataset kata kasar
KASAR_FILE = Path(__file__).parent / 'dataset_kasar.json'
SPAM_FILE = Path(__file__).parent / 'dataset_spam.json'

def load_dataset(filepath):
    """Load dataset dari JSON file"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            return json.load(f)
    except:
        return []

def analyze_text(text):
    """Analyze text untuk kata kasar, spam, dan buat clean version"""
    
    # Load kata kasar dan spam dataset
    kasar_list = load_dataset(KASAR_FILE)
    spam_list = load_dataset(SPAM_FILE)
    
    text_lower = text.lower()
    is_kasar = False
    is_spam = False
    clean_text = text
    
    # Check untuk kata kasar
    if kasar_list:
        for kata in kasar_list:
            if isinstance(kata, dict):
                kata_str = kata.get('kata', '').lower()
            else:
                kata_str = str(kata).lower()
            
            if kata_str and kata_str in text_lower:
                is_kasar = True
                # Replace kata kasar dengan asterisk
                clean_text = re.sub(
                    rf'\b{re.escape(kata_str)}\b',
                    '*' * len(kata_str),
                    clean_text,
                    flags=re.IGNORECASE
                )
    
    # Check untuk spam patterns
    spam_patterns = [
        r'(?:http|https)://',  # URLs
        r'bit\.ly|tinyurl|goo\.gl',  # URL shorteners
        r'(?:whatsapp|wa)\.me',  # WhatsApp links
        r'\b(?:follow|like|share|subscribe)\s+(?:for|my)',  # Spam phishing
        r'(?:jangan|hati|awas)[- ]?(?:lupa|lupakan)',  # Spam patterns
    ]
    
    # Normalize spam dataset: support both {"keywords":[], "patterns":[]} and list formats
    spam_keywords_from_file = []
    spam_patterns_from_file = []
    if isinstance(spam_list, dict):
        spam_keywords_from_file = spam_list.get('keywords', []) or []
        spam_patterns_from_file = spam_list.get('patterns', []) or []
    elif isinstance(spam_list, list):
        for item in spam_list:
            if isinstance(item, dict):
                # accept objects with 'pattern' key
                pat = item.get('pattern', '')
                if pat:
                    spam_patterns_from_file.append(pat)
            else:
                spam_patterns_from_file.append(str(item))

    # Check keywords (simple substring match)
    if spam_keywords_from_file:
        for kw in spam_keywords_from_file:
            if not kw:
                continue
            if kw.lower() in text_lower:
                is_spam = True
                break

    # Check regex patterns from file
    if not is_spam and spam_patterns_from_file:
        for pattern in spam_patterns_from_file:
            if not pattern:
                continue
            if re.search(pattern, text_lower, re.IGNORECASE):
                is_spam = True
                break
    
    # Check basic spam patterns
    if not is_spam:
        for pattern in spam_patterns:
            if re.search(pattern, text_lower):
                is_spam = True
                break
    
    # Determine status
    if is_kasar or is_spam:
        status = 'Rejected'  
    else:
        status = 'Approved'  
    
    # Calculate cosine score (simplified - just word similarity)
    skor_cosine = 0.0
    if not is_kasar and not is_spam:
        skor_cosine = 1.0
    elif is_kasar:
        skor_cosine = 0.3
    elif is_spam:
        skor_cosine = 0.2
    
    return {
        'clean_text': clean_text,
        'is_kasar': 1 if is_kasar else 0,
        'is_spam': 1 if is_spam else 0,
        'status': status,
        'skor_cosine': skor_cosine
    }

def main():
    if len(sys.argv) < 2:
        result = {
            'clean_text': None,
            'is_kasar': 0,
            'is_spam': 0,
            'status': 'Error',
            'skor_cosine': 0.0,
            'error': 'No text provided'
        }
        print(json.dumps(result, ensure_ascii=False))
        sys.exit(1)
    
    text = sys.argv[1]
    
    # Analyze text
    result = analyze_text(text)
    
    # Output as JSON
    print(json.dumps(result, ensure_ascii=False))

if __name__ == '__main__':
    main()
