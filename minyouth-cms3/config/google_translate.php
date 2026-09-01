<?php
/**
 * Google Cloud Translation settings.
 *
 * Set GOOGLE_TRANSLATE_API_KEY in the Apache/PHP environment. Never commit
 * the key to this file or expose it to browser-side JavaScript.
 */

define('GOOGLE_TRANSLATE_API_KEY', (string)(getenv('GOOGLE_TRANSLATE_API_KEY') ?: ''));