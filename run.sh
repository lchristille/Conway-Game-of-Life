#!/bin/bash

docker build -t conway_game_of_life .

docker run -it --rm \
            -e TOTAL_TICKS=20 \
            -e TICK_INTERVAL_IN_MS=1000 \
            conway_game_of_life