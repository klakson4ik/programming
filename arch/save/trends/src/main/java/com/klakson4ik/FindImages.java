package com.klakson4ik;

import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import static org.openqa.selenium.support.ui.ExpectedConditions.visibilityOfElementLocated;
import java.time.Duration;

import java.util.List;
import java.util.ArrayList;

public class FindImages extends RealtimeContent {
 // public class FindImages extends Init {
    private List<String>images;
    private List<String>imagesFull;
    private List<String>imagesAlt;
    private List<WebElement> imagesBlock;
    private WebElement block;
    final private String SELECTOR_URL = "Images";
    final private String SELECTOR_BLOCK = "islmp";
    final private String SELECTOR_IMAGES_BLOCK = "rg_i";
    final private String SELECTOR_IMAGES_FULL_BLOCK = "BIB1wf";
    final private String SELECTOR_IMAGES_FULL = "n3VNCb";

    public FindImages(){
        System.out.println("Images page download");
        createTrendsData();
        System.out.println("Images save");
    }

    private void createTrendsData() {
        try {
            for (RealtimeNode node : trendsData){
                driver.get("https://www.google.com/search?q=" + node.getTitle());
                System.out.println("Images title: " + node.getTitle());
                // driver.get("https://www.google.com/search?q=world");
                String imagesUrl = driver.findElement(By.xpath("//a[text()=\'" + SELECTOR_URL  +"\']")).getAttribute("href");        
                driver.get(imagesUrl);
                block = wait.until(visibilityOfElementLocated(By.xpath("//div[@id=\'" + SELECTOR_BLOCK  + "\']")));
                imagesBlock = new ArrayList<WebElement>();
                imagesBlock = block.findElements(By.className(SELECTOR_IMAGES_BLOCK));
                images = new ArrayList<String>();
                imagesFull = new ArrayList<String>();
                imagesAlt = new ArrayList<String>();
                byte count = 0;
                for (WebElement imageBlock : imagesBlock){
                    if(count == 5){
                        break;
                    }
                    images.add(imageBlock.getAttribute("src"));
                    imagesAlt.add(imageBlock.getAttribute("alt"));
                    imageBlock.click();
                    Thread.sleep(1000);
                    WebElement imageFullBlock = wait.until(presenceOfElementLocated(By.className(SELECTOR_IMAGES_FULL_BLOCK)));
                    String imageFullSrc = imageFullBlock.findElement(By.className(SELECTOR_IMAGES_FULL)).getAttribute("src");
                    imagesFull.add(imageFullSrc);
                    count++;
                }
                
                node.setImages(images);
                node.setImagesAlt(imagesAlt);
                node.setImagesFull(imagesFull);
                System.out.println("\u001B[32m Images title: " + node.getTitle() + " DONE ========>\u001B[0m");
                // new ModelDB().storeImagesDB(node); 
            }
        } catch (Exception e) {
            // driver.quit();
            e.printStackTrace();
        }
    }

    public List<RealtimeNode> getTrendsData(){
        return trendsData;
    }
}
