#! /bin/sh

host="laptop"
localtime="/Europe/Moscow"

ln -sf /usr/share/zoneinfo/$localtime /etc/localtime
hwclock --systohc
cat "en_US.UTF-8 UTF-8/nru_RU.UTF-8 UTF-8" > /etc/locale.conf
locale-gen
cat "LANG=ru_RU.UTF-8" > /etc/locale.conf
cat $host > /etc/hostname
cat "127.0.0.1/tlocalhost/n::1/tlocalhost/n127.0.1.1/tlocalhost.localdomain/t$host" > /etc/hosts
bootctl install
cat "default arch.conf/ntimeout 1/nconsole-mode/neditor no" > /boot/loader/loader.conf
cat "title Arch Linux/nlinux /nvmlinuz-linux/ninitrd /intel-ucode.img/ninitrd /initramfs-linux.img/noptions root="LABEL=ROOT" rw" > /boot/loader/entries/arch.conf
cat "title Arch Linux (fallback)/nlinux /nvmlinuz-linux/ninitrd /intel-ucode.img/ninitrd /initramfs-linux-fallback.img/noptions root="LABEL=ROOT" rw" > /boot/loader/entries/arch-fallback.conf

systemctl enable systemd-boot-update
systemctl enable iwd
systemctl enable systemd-resolved
systemctl enable systemd-networkd

pacman -Suy
pacman -S --noconfirm man-db man-pages texinfo vim sway swaybg swaylock swayidle mpv htop sudo alsa-utils brightnessctl firefox code fuzzel i3blocks otf-font-awesome slurp grim sshfs unzip wget curl git wl-clipboard zsh mako polkit 
