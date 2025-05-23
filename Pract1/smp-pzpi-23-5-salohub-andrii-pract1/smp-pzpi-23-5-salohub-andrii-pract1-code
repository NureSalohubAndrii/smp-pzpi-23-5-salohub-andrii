#!/bin/bash
validate_inputs() {
    if (( $# != 2 )); then
        echo "Помилка: Вкажіть два аргументи: висоту дерева та ширину снігу." >&2
        exit 1
    fi
    local height=$1 snow=$2
    if (( height < 8 )); then
        echo "Помилка: Мінімальна висота дерева - 8. Вказано: $height." >&2
        exit 1
    fi
    local max_snow_width=$(( height - (height % 2) ))
    local min_snow_width=$(( max_snow_width - 1 ))
    if (( snow < min_snow_width )); then
        echo "Помилка: Мінімальна ширина снігу: $min_snow_width." >&2
        exit 1
    fi
    if (( snow > max_snow_width )); then
        echo "Помилка: Максимальна ширина снігу: $max_snow_width." >&2
        exit 1
    fi
}

print_centered_line() {
    local width=$1 symbol=$2 total_width=$3
    local spaces=$(( (total_width - width) / 2 + 1 ))
    echo -n "$(for i in $(seq 1 $spaces); do echo -n " "; done)"
    echo "$(for i in $(seq 1 $width); do echo -n "$symbol"; done)"
}

draw_tier() {
    local tier_height=$1
    tier_max_width=$2
    local symbols=("*" "#")
    local index=0
    i=1
    until (( i > tier_height / 2 )); do
        print_centered_line $(( 1 + (i - 1) * 2 )) "${symbols[$index]}" "$tier_max_width"
        index=$((1 - index))
        ((i++))
    done
    while (( i <= tier_height )); do
        print_centered_line $(( 1 + (i - 1) * 2 )) "${symbols[$index]}" "$tier_max_width"
        index=$((1 - index))
        ((i++))
    done
    for (( row = 2; row <= tier_height; row++ )); do
        print_centered_line $(( 1 + (row - 1) * 2 )) "${symbols[$index]}" "$tier_max_width"
        index=$((1 - index))
    done
}

draw_trunk_and_snow() {
    local snow_width=$1
    local pad=$(( (snow_width - 3) / 2 ))
    for trunk in 1 2; do
        echo "$(for i in $(seq 1 $pad); do echo -n " "; done)###"
    done
    echo -n "$(for i in $(seq 1 $snow_width); do echo -n "*"; done)"
    echo ""
}

validate_inputs "$@"
tree_height=$(( $1 - ($1 % 2) ))
snow_width=$(( tree_height - 1 ))
draw_tier $(((tree_height - 1) / 2)) $((snow_width - 2))
draw_trunk_and_snow "$snow_width"
# EOF
