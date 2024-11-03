package com.klakson4ik;

import java.sql.Connection;
import java.sql.SQLException;
import java.sql.PreparedStatement;
import java.sql.Statement;
import java.sql.ResultSet;
import java.sql.Date;
import java.time.LocalDate; 
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.sql.Timestamp;
import com.jcraft.jsch.*;
import java.time.LocalDateTime; // Import the LocalDateTime class
import java.time.format.DateTimeFormatter; // Import the DateTimeFormatter class

import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.FileOutputStream;

import java.io.FileWriter;
import java.io.IOException;

public class SiteMap {
    private static String data;
    private static LocalDate dateNow = LocalDate.now();
    private static LocalDate dateYesterday = LocalDate.now().minusDays(1);
    private static LocalDate date2DaysAgo = LocalDate.now().minusDays(2);
    private static LocalDate date3DaysAgo = LocalDate.now().minusDays(3);
    private static LocalDate date4DaysAgo = LocalDate.now().minusDays(4);
    private static LocalDate date5DaysAgo = LocalDate.now().minusDays(5);

    public static void start(){
        try (Connection connection = new DBConnector().getDBConnection()){
            String query = "SELECT id, date_create FROM articles";
            Statement statement = connection.createStatement();
            ResultSet rs = statement.executeQuery(query);
            data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" +
                "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
            firstLines();
            while(rs.next()){
                Date date1 = rs.getDate(2);
                DateFormat df = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'+03:00'");
                String date = df.format(rs.getTimestamp(2));
                 data += "\n\t<url>" + 
                 "\n\t\t<loc>https://gonomax.com/news/index?id=" + rs.getInt(1) + "</loc>" +
                 "\n\t\t<lastmod>" + date + "</lastmod>" +
                 "\n\t\t<changefreq>never</changefreq>";
                 data += "\n\t\t<priority>" + getPriority(date1) + "</priority>" +
                 "\n\t</url>";
            }
            data += "\n</urlset>";
            writeSSHFile();
        }catch(SQLException e){
            // e.printStackTrace();
        }
    }
    private static void firstLines(){
        DateTimeFormatter formatD = DateTimeFormatter.ofPattern("yyyy-MM-dd'T'HH:mm:ss'+03:00'");
        LocalDateTime ldt = LocalDateTime.now().plusHours(3);
        String date = ldt.format(formatD);
         data += "\n\t<url>" + 
         "\n\t\t<loc>https://gonomax.com</loc>" +
         "\n\t\t<lastmod>" + date + "</lastmod>" +
         "\n\t\t<changefreq>always</changefreq>" +
         "\n\t\t<priority>1.0</priority>" +
         "\n\t</url>";
    }

    private static String getPriority(Date date1){
        LocalDate dateSql = date1.toLocalDate();
        if(dateSql.equals(dateNow)){
            return "1.0";
        }
        if(dateSql.equals(dateYesterday)){
            return "0.9";
        }
        if(dateSql.equals(date2DaysAgo)){
            return "0.8";
        }
        if(dateSql.equals(date3DaysAgo)){
            return "0.7";
        }
        if(dateSql.equals(date4DaysAgo)){
            return "0.6";
        }
        if(dateSql.equals(date5DaysAgo)){
            return "0.5";
        }
        return "0.4";
    }

    private static void writeSSHFile(){
        String user = "maks";
        String password = "h";
        String host = "192.168.0.110";
        int port = 22;
        String remoteFile = "/home/maks/lxc_data/nginx/www/public/sitemap.xml";
        String file = "/home/maks/trends/sitemap.xml";

        try {
            JSch jsch = new JSch();
            Session session = jsch.getSession(user, host, port);
            session.setPassword(password);
            session.setConfig("StrictHostKeyChecking", "no");
            System.out.println("Establishing Connection...");
            session.connect();
            System.out.println("Connection established.");
            System.out.println("Crating SFTP Channel.");
            ChannelSftp sftpChannel = (ChannelSftp) session.openChannel("sftp");
            sftpChannel.connect();
            System.out.println("SFTP Channel created.");

            try(FileWriter writer = new FileWriter(file, false)){
                writer.write(data);
                writer.flush();
            }
            catch(IOException ex){
                System.out.println(ex.getMessage());
            }
            sftpChannel.put(file, remoteFile);
            sftpChannel.disconnect();
            session.disconnect();


        } catch (JSchException | SftpException e) {
            e.printStackTrace();
        }
    }
}


