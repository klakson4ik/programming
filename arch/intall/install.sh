#! /bin/sh

# time sync
timedatectl

# format fs
mkfs.fat -F 32 -n BOOT /dev/nvme0n1p1                                                                                                                                                                                                                                           11:04:46
mkswap -L SWAP /dev/nvme0n1p2                                                                                                                                                                                                                                           11:04:46
mkfs.ext4 -L ROOT /dev/nvme0n1p3                                                                                                                                                                                                                                           11:04:46
mkfs.ext4 -L HOME /dev/nvme0n1p4                                                                                                                                                                                                                                           11:04:46

# mount fs
mount -L ROOT /mnt
mount -L BOOT --mkdir /mnt/boot
mount -L HOME --mkdir /mnt/home
swapon -L SWAP

# install base package
pacstrap -K /mnt base linux linux-firmware intel-ucode iwd

# generate fstab
genfstab -U /mnt >> /mnt/etc/fstab
