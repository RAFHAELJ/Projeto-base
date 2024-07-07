#!/bin/sh

export AWS_LAMBDA_RUNTIME_API=localhost:8080
exec "$@"
