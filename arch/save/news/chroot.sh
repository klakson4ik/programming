user=maks
mac="$(ip a | grep ether | gawk '{print $2}')"
home=/home/$user
defaultConf=$home/.config/lxc/default.conf
host=

useradd -m -G wheel -s /bin/bash maks

ln -sf /usr/share/zoneinfo/Europe/Moscow /etc/localtime
hwclock --systohc
echo "en_US.UTF-8 UTF-8" > /etc/locale.gen
locale-gen
touch /etc/locale.conf
echo "LANG=en_US.UTF-8" > /etc/locale.conf
touch /etc/hostname
echo "$host" > /etc/hostname
echo -e "\n127.0.0.1\tlocalhost \n::1\tlocalhost \n127.0.1.1\t$host.localdomain\t$host" >> /etc/hosts
sed -i "52c\HOOKS=(base udev autodetect modconf block keyboard lvm2 filesystems fsck)" /etc/mkinitcpio.conf
mkinitcpio -p linux-hardened
bootctl install
echo -e "default\tarch.conf \ntimeout\t4 \nconsole-mode\tmax \neditor\tno" > /boot/loader/loader.conf
echo -e "title\tArch Linux \nlinux\t/vmlinuz-linux-hardened \ninitrd\t/intel-ucode.img \ninitrd\t/initramfs-linux-hardened.img \noptions\troot="LABEL=root" rw" > boot/loader/entries/arch.conf

touch /etc/doas.conf
echo -e "permit keepenv :wheel"  > /etc/doas.conf

mkdir -p $home/.config/lxc
touch $user/.config/lxc/default.conf
echo -e "lxc.idmap = u 0 100000 65536 \nlxc.idmap = g 0 100000 65536 \nlxc.start.auto = 1 \nlxc.start.delay = 5 \nlxc.net.0.type = veth \nlxc.net.0.link = br0 \nlxc.net.0.flags = up \nlxc.mount.auto = cgroup:mixed \nlxc.autodev = 1 \nlxc.include = /usr/share/lxc/config/common.conf.d/00-lxcfs.conf" > $defaultConf
touch /etc/subuid
echo -e "1000:100000:65536" > /etc/subuid
touch /etc/subuid
echo -e "1000:100000:65536" > /etc/subgid
touch /etc/sysctl.d/00-local-userns.conf
echo "kernel.unprivileged_userns_clone=1" > /etc/sysctl.d/00-local-userns.conf
touch /etc/lxc/lxc-usernet
echo "$user veth br0 2" > /etc/lxc/lxc-usernet
mkdir -p /var/lib/lxcfs
mkdir -p $home/.cache/lxc/download
mkdir -p $home/.local/share/lxc
touch /etc/systemd/user/lxc-autostart.service

chown -R maks:users $home
chmod +x $home

touch /etc/systemd/network/br0.netdev
touch /etc/systemd/network/br0-enp.network
touch /etc/systemd/network/br0.network
touch /etc/systemd/network/50-br0-wol.link

echo -e "[NetDev] \nName=br0 \nKind=bridge \nMACAddress=$mac" > /etc/systemd/network/br0.netdev
echo -e "[Match] \nName=enp* \n \n[Network] \nBridge=br0" > /etc/systemd/network/br0-enp.network
echo -e "[Match] \nName=br0 \n \n[Network] \nLinkLocalAddressing=ipv4 \nIPv6AcceptRA=no \nDHCP=ipv4" > /etc/systemd/network/br0.network
echo -e "[Match] \nMACAddress=$mac \n\n[Link] \nNamePolicy=kernel database onboard slot path \nMACAddressPolicy=persistent \nWakeOnLan=magic" > /etc/systemd/network/50-br0-wol.link

echo -e "[Unit] \nDescription=\"lxc-autostart for lxc user\" \n\n[Service] \nType=oneshot \nExecStart=/usr/bin/lxc-autostart \nExecStop=/usr/bin/lxc-autostart -s \nRemainAfterExit=1 \n\n[Install] \nWantedBy=default.target" > /etc/systemd/user/lxc-autostart.service

systemctl --user enable lxc-autostart
loginctl enable-linger $user

systemctl enable sshd
systemctl enable systemd-networkd
systemctl enable lxc
systemctl enable lxcfs

exit
exit
