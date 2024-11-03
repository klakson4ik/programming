#cp -r /mnt/maks/cp .
#umount -R /mnt
boot=mmcblk*p1
root=mmcblk*p2

timedatectl set-ntp true
pvcreate /dev/$root
vgcreate LVM /dev/$root
lvcreate -L 1.5G -n root LVM
lvcreate -L 2G -n swap LVM
lvcreate -l 100%FREE -n home LVM

mkfs.btrfs -f -L root /dev/LVM/root 
mkfs.btrfs -f -L home /dev/LVM/home
mkfs.btrfs -f -L swap /dev/LVM/swap
mkfs.vfat -F32 /dev/$boot
mkswap /dev/LVM/swap
swapon /dev/LVM/swap

mount /dev/LVM/root /mnt
mkdir /mnt/boot
mkdir /mnt/home
mount /dev/$boot /mnt/boot
mount /dev/LVM/home /mnt/home

pacstrap /mnt base linux-hardened lvm2 vi doas efibootmgr btrfs-progs intel-ucode openssh lxc lxcfs
genfstab -U /mnt >> /mnt/etc/fstab
touch /mnt/root/.bashrc
echo "~/chroot.sh" >> /mnt/root/.bashrc
cp chroot.sh /mnt/root
arch-chroot /mnt
rm /mnt/root/.bashrc
rm /mnt/root/chroot.sh

#cp -r cp /mnt/home/maks/

arch-chroot /mnt
