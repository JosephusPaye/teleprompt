# Set the number of lines and entries in the history.
export HISTFILESIZE=50000
export HISTSIZE=50000

# Add a timestamp to each command in the history.
export HISTTIMEFORMAT="%Y/%m/%d %H:%M:%S:   "

# Duplicate lines and lines starting with a space are not put into the history.
export HISTCONTROL=ignoreboth

# Append to the history file, don't overwrite it.
shopt -s histappend

# Enable case-insensitive autocompletion.
bind 'set completion-ignore-case on'

# Setup Git credentials, from the DOCKER_GIT_USER_x env variables
git config --global user.name "$GIT_USER_NAME"
git config --global user.email "$GIT_USER_EMAIL"

# Determine git branch.
parse_git_branch() {
    git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'
}

# Custom bash prompt via kirsle.net/wizards/ps1.html
export PS1="\n\[$(tput bold)\]\[$(tput setaf 2)\]\w $(parse_git_branch) \n\[$(tput setaf 6)\]> \[$(tput sgr0)\]\[$(tput sgr0)\]"
