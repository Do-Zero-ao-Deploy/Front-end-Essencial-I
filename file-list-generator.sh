#!/bin/bash

export EOL="\n"
export MENU=""

push_to_menu() {
    if [ -z $2 ]; then
        MENU="${MENU}\n  - ${1}"
    else
        MENU="${MENU}\n  - [${1}](${2})"
    fi
    # MENU="${MENU}\n${1}"
}

get_menu_lines() {
    local EOL="\n";
    local HEADER_LINES="${EOL}${EOL}### Pastas${EOL}${EOL}"

    for line in $(find . -type d | grep -v ".git"|grep -vE "^.$"|grep -vE "file-list|php"); do
        if [ -d $line ]; then
            HEADER_LINES="${HEADER_LINES}  - [${line}](${line})${EOL}"
        fi
    done

    echo -e "${HEADER_LINES}";
}

get_lines() {
    local EOL="\n";
    local LINES=""
    local DASHES="-------------------------------------------------"

    for line in $(find . | grep -v ".git"|grep -vE "^.$"|grep -vE "file-list|php"); do
        if [ -d $line ]; then
            LINES="${LINES}${EOL}${EOL}${DASHES}${EOL}### [${line}](${line})${EOL}${DASHES}"
        fi

        if [ -f $line ]; then
            LINES="${LINES}${EOL}  - [\`${line}\`](${line})"
        fi
    done

    echo -e "${LINES}";
}

MENU="$(get_menu_lines)"

# push_to_menu A  ## Adiciona A
# push_to_menu A  B ## Adiciona [A](B)

get_menu() {
    local EOL="\n";
    local LINES=""
    local DASHES="-------------------------------------------------"
    echo -e "${MENU}${EOL}${DASHES}${EOL}${EOL}"
}

get_header() {
    # Sobre o curso: https://dozeroaodeploy.com.br/
    # Link para compra: https://chk.eduzz.com/atuuhb25
    echo -e "# Front-end Essencial I _(Web Essencial)_"
    echo -e "## [Jornada do Zero ao Deploy](https://dozeroaodeploy.com.br)"
    echo -e "$(get_menu)"
}

get_footer() {
    local EOL="\n";
    local LINES=""
    local DASHES="-------------------------------------------------"

    echo -e ""
    echo -e "${DASHES}"
    echo -e "#### Links"
    echo -e " - [Sobre o curso][https://dozeroaodeploy.com.br/]"
    echo -e " - [Link para compra][https://chk.eduzz.com/atuuhb25]"
    echo -e " - [Canal do Curso][https://www.youtube.com/channel/UCaIKqUtNnZme66qHdJAhCmQ?sub_confirmation=1]"
    echo -e ""
    echo -e ""
    echo -e ""
    echo -e "${DASHES}"
    echo -e "Gerado via \`file-list-generator.sh\` em \`$(date +"%Y-%m-%d %T %Z")\`"
    echo -e ""
}

MD_HEADER=$(get_header)
MD_FOOTER=$(get_footer)

FILE_RESULT_LINES=""
FILE_RESULT_LINES="${FILE_RESULT_LINES}${MD_HEADER}"
FILE_RESULT_LINES="${FILE_RESULT_LINES}$(get_lines)"
FILE_RESULT_LINES="${FILE_RESULT_LINES}${MD_FOOTER}"

echo -e "${FILE_RESULT_LINES}"
echo -e "${FILE_RESULT_LINES}" > file-list.md
