import pandas as pd
from pathlib import Path
import json
import sys

BASE_DIR = Path(__file__).parent.parent
ALTERNATIVES_CATEGORIZED_DIR = BASE_DIR / "storage" / "app" / "lowongan_magang"

ALTERNATIVES_CATEGORIZED_FILEPATH = ALTERNATIVES_CATEGORIZED_DIR / "alternatives_categorized.json"
OUTPUT_FILEPATH = ALTERNATIVES_CATEGORIZED_DIR / "alternatives_categorized.csv"

try:
    if not ALTERNATIVES_CATEGORIZED_FILEPATH.exists():
        raise FileNotFoundError(f"File not found: {ALTERNATIVES_CATEGORIZED_FILEPATH}")

    df = pd.read_json(ALTERNATIVES_CATEGORIZED_FILEPATH)

    df['id'] = ["A" + str(i+1) for i in range(len(df))]

    df.to_csv(OUTPUT_FILEPATH, index=False)
    print(f"\nSuccessfully converted to CSV: {OUTPUT_FILEPATH}")

except FileNotFoundError as e:
    print(f"\nError: {e}")
except json.JSONDecodeError as e:
    print(f"\nJSON decoding error: {e}")
except PermissionError as e:
    print(f"\nPermission error: {e}")
except Exception as e:
    print(f"\nUnexpected error: {e}")
    sys.exit(1)
