package org.example;

import org.example.lib.client.ClientUdp;
import org.example.lib.server.ServerUdp;
import org.example.lib.server.ServerUdpChannel;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

public class Main {
    final private static int port = 41200;
    public static void main(String[] args) {
        udpChannel();
    }

    public static void udp(){
        new ServerUdp(port).start();
//        new Client("localhost", port).channel();
        System.out.println("Введиет сообщение");
        BufferedReader reader = new BufferedReader(new InputStreamReader(System.in));
        String msg = null;
        try {
            msg = reader.readLine();
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        ClientUdp client = new ClientUdp("localhost",port);
        client.send(msg);
    }

    public static void udpChannel(){
        new ServerUdpChannel(port).start();
        System.out.println("Введиет сообщение");
        BufferedReader reader = new BufferedReader(new InputStreamReader(System.in));
        String msg = null;
        try {
            msg = reader.readLine();
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        ClientUdp client = new ClientUdp("localhost",port);
        client.send(msg);
    }
}