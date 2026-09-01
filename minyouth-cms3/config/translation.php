<?php

define('FREE_TRANSLATE_API_URL', (string)(getenv('FREE_TRANSLATE_API_URL') ?: 'http://127.0.0.1:8000/translate'));

function translation_provider_languages(): array
{
	return ['en', 'sn', 'nr'];
}