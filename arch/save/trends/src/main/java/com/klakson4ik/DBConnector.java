package com.klakson4ik;

import java.sql.DriverManager;
import java.sql.Connection;
import java.sql.SQLException;
import java.lang.Class;

class DBConnector {
    private static final String USER = "maks";
    private static final String PASSWORD = "Ntktdbpjh55";
    private static final String URL = "jdbc:mariadb://192.168.0.110:3306/news_db";
    private static final String DRIVER = "org.mariadb.jdbc.Driver";
    private static Connection connection;

    public static Connection getDBConnection() {
        try{
            Class.forName(DRIVER);
        }catch(ClassNotFoundException e){
            e.printStackTrace();
        }
        try{
            connection = DriverManager.getConnection(URL, USER, PASSWORD);
        }catch(SQLException e){
            e.printStackTrace();
        }
        return connection;
    }
}

// import java.sql.Connection;
// import java.sql.SQLException;
        // try (Connection connection = new DBConnector().getDBConnection()){
        //      
        // }catch(SQLException e){
        //  e.printStackTrace();
        // }

// CREATE TABLE `articles` (
//   `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
//   `title` char COLLATE 'utf8_general_ci' NOT NULL,
//   `keywords` char COLLATE 'utf8_general_ci' NOT NULL,
//   `description` text COLLATE 'utf8_general_ci' NOT NULL,
//   `text` text COLLATE 'utf8_general_ci' NOT NULL,
//   `url` char COLLATE 'utf8_general_ci' NOT NULL
// ) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
