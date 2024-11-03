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

public class FindContent extends FindImages {


    public FindContent(){
        for (RealtimeNode node : trendsData){
            find(node);
        }
        System.out.println("Description download");
        System.out.println("Add " + ModelDB.getCount() + " articles");
        driver.quit();
    }

    private void find(RealtimeNode node) {
        // if(node.getUrl() == null){
        //     System.out.println("Not URL");
        //     return;
        // }

        // try{
        //     driver.get(node.getUrl());
        //     System.out.println("Page downloading " + node.getUrl());
        // //    WebElement head = new WebDriverWait(driver, Duration.ofSeconds(5))
        //     WebElement head = wait.until(presenceOfElementLocated(By.xpath("//head//meta[@name='description']")));
        //     String description = head.getAttribute("content");
        //     if(description.isEmpty()) 
        //         node.setDescription(node.getTitle()); 
        //     else{
        //         System.out.println("Description get real");
        //         node.setDescription(description);
        //     }
        // }catch ( NoSuchElementException e) {
        //     node.setDescription(node.getTitle());
        //     System.out.println("Not Head");
        // }catch ( TimeoutException e) {
        //     node.setDescription(node.getTitle());
        //     System.out.println("Not Head");
        // }catch ( WebDriverException e) {
        //     node.setDescription(node.getTitle());
        //     System.out.println("Not Head");
        // }catch ( NullPointerException e) {
        //     node.setDescription(node.getTitle());
        //     System.out.println("Not Head");
        // } finally {
            node.setDescription(node.getTitle()); 
            new BoilerPipe(node);
            if(node.getText().length() > 200 && (!node.getText().isEmpty())){
                new ModelDB().storeDB(node);
                new ModelDB().storeImagesDB(node); 
                new ModelDB().storeDescriptionDB(node);
            }
        // }
    }
}
