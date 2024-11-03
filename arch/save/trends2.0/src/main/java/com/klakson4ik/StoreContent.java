package com.klakson4ik;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.WebDriverException;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import java.time.Duration;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.NoSuchElementException;
import java.lang.InterruptedException;

import java.util.List;
import java.util.ArrayList;

public class StoreContent extends Init {


    public StoreContent(){
        createTrendsData();
        System.out.println("Add " + ModelDB.getCount() + " articles");
    }

    protected void createTrendsData() {
        List<Node> nodesRemove = new ArrayList<Node>();
        for (Node node : TrendsData.getList()){
            if(node.getText().length() > 800 && (!node.getText().isEmpty())){
                ModelDB.storeDB(node);
                ModelDB.storeImagesDB(node); 
//                ModelDB.storeDescriptionDB(node);
            }else{
                nodesRemove.add(node);
            }
        }
        for(Node nodeRemove : nodesRemove){
            TrendsData.removeNode(nodeRemove);
        }
    }
}
