#!/bin/bash
set -e

install() {
    echo "There are nothing to install"
}

tests() {
    echo "There are no tests"
}

run() {
    supervisord
}

case "$1" in
"install")
    echo "Install"
    install
    ;;
"tests")
    echo "Tests"
    tests
    ;;
"run")
    echo "Run"
    run
    ;;
*)
    echo "Custom command : $@"
    exec "$@"
    ;;
esac