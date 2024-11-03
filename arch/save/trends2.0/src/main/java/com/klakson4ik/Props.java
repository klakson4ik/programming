package com.klakson4ik;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

public class Props{
    // private static final String PATH_TO_CONFIG_DEV_PROPERTIES = "/home/maks/project/trends2.0/src/main/resources/config.properties";
    // private static final String PATH_TO_PROJECT_DEV_PROPERTIES = "/home/maks/project/trends2.0/src/main/resources/project.properties";
    private static final String PATH_TO_CONFIG_PROD_PROPERTIES = "/home/maks/trends/config.properties";
    // private static final String PATH_TO_PROJECT_PROD_PROPERTIES = "/home/maks/trends/project.properties";
    private static String data;

    public static String getProp(String prop){
        createProp(prop, PATH_TO_CONFIG_PROD_PROPERTIES);
        // createProp(prop, PATH_TO_CONFIG_DEV_PROPERTIES);
        return data;
    }

    // public static String getPropDev(String prop){
    //     createProp(prop, PATH_TO_DEV_PROPERTIES);
    //     return data;
    // }

    private static void createProp(String prop, String PATH){
        FileInputStream fileInputStream;
        Properties props = new Properties();
        try {
            fileInputStream = new FileInputStream(PATH);
            props.load(fileInputStream);
            data = props.getProperty(prop);
        } catch (IOException e) {
            System.out.println("file not found " + PATH);
            e.printStackTrace();
        }
    }
}
