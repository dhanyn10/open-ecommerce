#!/bin/sh
set -e

# Execute the command passed to this script (the Dockerfile's CMD)
exec "$@"
