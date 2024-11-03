user=@1
mac="$(ip a | grep ether | gawk '{print $2}')"
home=/home/$user
defaultConf=$home/.config/lxc/default.conf
mkdir -p $home/.config/lxc
touch $user/.config/lxc/default.conf
echo -e "lxc.idmap = u 0 100000 65536 \nlxc.idmap = g 0 100000 65536 \nlxc.net.0.type = veth \nlxc.net.0.link = br0 \nlxc.net.0.flags = up \nlxc.mount.auto = cgroup:mixed \nlxc.autodev = 1 \nlxc.include = /usr/share/lxc/config/common.conf.d/00-lxcfs.conf" > $defaultConf
touch /etc/subuid
echo -e "#1000:100000:65536" > /etc/subuid
touch /etc/subuid
echo -e "#1000:100000:65536" > /etc/subgid
touch /etc/sysctl.d/00-local-userns.conf
echo "kernel.unprivileged_userns_clone=1" > /etc/sysctl.d/00-local-userns.conf
touch /etc/lxc/lxc-usernet
echo "$user veth br0 2" > /etc/lxc/lxc-usernet
mkdir -p /var/lib/lxcfs
mkdir -p $home/.cache/lxc/download
mkdir -p $home/.local/share/lxc

chowm -R maks:users $home
chmod +x $home

touch /etc/systemd/network/br0.netdev
touch /etc/systemd/network/br0-enp.network
touch /etc/systemd/network/br0.network
touch /etc/systemd/network/50-br0-wol.link

echo -e "[NetDev] \nName=br0 \nKind=bridge \nMACAddress=$mac" > /etc/systemd/network/br0.netdev
echo -e "[Match] \nName=enp* \n \n[Network] \nBridge=br0" > /etc/systemd/network/br0-enp.network
echo -e "[Match] \nName=br0 \n \n[Network] \nLinkLocalAddressing=ipv4 \nIPv6AcceptRA=no \nDHCP=ipv4" > /etc/systemd/network/br0.network
echo -e "[Match] \nMACAddress=$mac \n\n[Link] \nNamePolicy=kernel database onboard slot path \nMACAddressPolicy=persistent \nWakeOnLan=magic" > /etc/systemd/network/50-br0-wol.link

systemctl enable sshd
systemctl enable systemd-networkd
systemctl enable lxc
systemctl enable lxcfs
