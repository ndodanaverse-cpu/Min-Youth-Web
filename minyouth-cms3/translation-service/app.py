import os
from functools import lru_cache

from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
from transformers import AutoModelForSeq2SeqLM, AutoTokenizer


MODEL_NAME = os.getenv("NLLB_MODEL", "facebook/nllb-200-distilled-600M")
SOURCE_LANGUAGE = "eng_Latn"

LANGUAGE_CODES = {
    "ny": "nya_Latn",
    "en": "eng_Latn",
    "nd": "nde_Latn",
    "nde": "nde_Latn",
    "sn": "sna_Latn",
    "st": "sot_Latn",
    "tso": "tso_Latn",
    "tn": "tsn_Latn",
    "ve": "ven_Latn",
    "xh": "xho_Latn",
}


class TranslationRequest(BaseModel):
    values: list[str] = Field(min_length=1, max_length=32)
    target: str


class TranslationResponse(BaseModel):
    translations: list[str]


app = FastAPI(title="MinYouth NLLB Translation Service")


@lru_cache(maxsize=1)
def get_model():
    tokenizer = AutoTokenizer.from_pretrained(MODEL_NAME)
    model = AutoModelForSeq2SeqLM.from_pretrained(MODEL_NAME)
    return tokenizer, model


@app.get("/health")
def health():
    return {"status": "ok", "model": MODEL_NAME}


@app.post("/translate", response_model=TranslationResponse)
def translate(request: TranslationRequest):
    target_language = LANGUAGE_CODES.get(request.target)
    if not target_language:
        raise HTTPException(status_code=422, detail="This language is not supported by the installed NLLB model.")

    tokenizer, model = get_model()
    tokenizer.src_lang = SOURCE_LANGUAGE
    encoded = tokenizer(request.values, return_tensors="pt", padding=True, truncation=True, max_length=1024)
    generated = model.generate(
        **encoded,
        forced_bos_token_id=tokenizer.convert_tokens_to_ids(target_language),
        max_length=1024,
    )
    translations = tokenizer.batch_decode(generated, skip_special_tokens=True)
    return TranslationResponse(translations=translations)