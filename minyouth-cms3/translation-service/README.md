# Local NLLB translation service

This service runs Meta's open NLLB-200 model locally. It does not need a
Google API key or per-character billing. The first request downloads the model
and may require several gigabytes of disk space and RAM.

From this directory, create a virtual environment and install dependencies:

```powershell
py -3.14 -m venv .venv
.\.venv\Scripts\Activate.ps1
python -m pip install -r requirements.txt
python -m uvicorn app:app --host 127.0.0.1 --port 8090
```

The PHP site calls `http://127.0.0.1:8090/translate`. Supported website codes
are `ny`, `en`, `nd`, `nde`, `sn`, `st`, `tso`, `tn`, `ve`, and `xh`. The remaining
codes should remain manual until a verified NLLB language mapping is available.