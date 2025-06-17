#!/bin/bash
set -x # Keep this, it's incredibly helpful!

VIDEO="${1}"
TIMESTAMP="${2}"
OUTPUT_DIR="${3}"
UNIQUE_KEY="${4}"
WATERMARK_PATH="${5}"

OUTPUT_FILENAME="${OUTPUT_DIR}${UNIQUE_KEY}.jpg"

# Use an array to store all FFmpeg arguments safely
FFMPEG_ARGS=("-ss" "${TIMESTAMP}" "-i" "${VIDEO}")

# Check if a watermark path was provided and if the file exists
if [ -n "${WATERMARK_PATH}" ] && [ -f "${WATERMARK_PATH}" ]; then
    # Add watermark inputs and filters as separate elements to the array
    FFMPEG_ARGS+=("-i" "${WATERMARK_PATH}")
    FFMPEG_ARGS+=("-filter_complex" "[1:v]scale=iw/3:ih/3[scaled_watermark];[0:v][scaled_watermark]overlay=W-w-20:H-h-20[out]")
    FFMPEG_ARGS+=("-map" "[out]")
else
    echo "Warning (process_capture.sh): Watermark path not provided or file does not exist: ${WATERMARK_PATH}" >&2
fi

# Add remaining common arguments
FFMPEG_ARGS+=("-frames:v" "1" "-q:v" "2" "${OUTPUT_FILENAME}")

# --- DEBUGGING LINE ---
# This will now show the command exactly as it should be executed by FFmpeg
echo "DEBUG (process_capture.sh): FFmpeg command to execute: ffmpeg ${FFMPEG_ARGS[*]}" >&2

# --- EXECUTE FFmpeg ---
# CRITICAL: Use "${FFMPEG_ARGS[@]}" to expand the array into separate arguments
ffmpeg "${FFMPEG_ARGS[@]}"

exit $?