#!/bin/bash
set -e

exec /root/.composer/vendor/bin/sigmie-crawl "$@"
