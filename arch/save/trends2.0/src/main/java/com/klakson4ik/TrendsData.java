package com.klakson4ik;

import java.util.ArrayList;
import java.util.List;

public class TrendsData{
    private static List<Node> trendsData = new ArrayList<Node>(); 

    public static void setData(Node data){
        trendsData.add(data);    
    }

    public static List<Node> getList(){
        return trendsData;
    }

    public static void removeNode(Node node){
        trendsData.remove(node);
    }
}
