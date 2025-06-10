package ru.kydryavtsev.lib.helper;

public class Converter {
    public static int toKB(long count){
        return (int) (count / 1024);
    }

    public static int toMB(long count){
        return (int) (count / 1048576);
    }

    public static int toGB(long count){
        return (int) (count / 1073741824);
    }
}
