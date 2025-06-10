package org.example.lib.client;

import java.io.IOException;
import java.net.*;
import java.nio.channels.DatagramChannel;

public class ClientUdp {
    private final DatagramSocket socket;
    private final InetAddress address;

    private final int port;

    public ClientUdp(String hostname, int port) {
        try {
            address = InetAddress.getByName(hostname);
            socket = new DatagramSocket();
        } catch (UnknownHostException | SocketException e) {
            throw new RuntimeException(e);
        }
        this.port = port;
    }

    public void send(String msg) {
        byte[] buffer = msg.getBytes();
        DatagramPacket packet
                = new DatagramPacket(buffer, buffer.length, address, port);
        try {
            socket.send(packet);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        byte[] responceBuffer = new byte[65503];
        packet = new DatagramPacket(responceBuffer, responceBuffer.length);
        try {
            socket.receive(packet);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        String received = new String(
                packet.getData(), 0, packet.getLength());
        System.out.println("Сообщение от Сервера: " + received);
    }
}
