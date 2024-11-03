package com.klakson4ik;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import java.time.Duration;

import java.util.List;
import java.util.ArrayList;

public class Realtime extends Init {
    final private String SELECTOR_MAIN_BLOCK;
    final private String SELECTOR_ITEMS;
    final private String SELECTOR_KEYWORDS;
    final private String SELECTOR_RANK_CHILD;
    final private String SELECTOR_BLOCK;
    private byte count = 0;

    {
        SELECTOR_MAIN_BLOCK = "homepage-trending-stories";
        SELECTOR_ITEMS = "details-wrapper";
        SELECTOR_KEYWORDS = "details-top";
        SELECTOR_RANK_CHILD = "index";
        SELECTOR_BLOCK = "summary-text";
    }

    public Realtime(){
        trendsData = new ArrayList<>();
        createTrendsData();
    }

    private void createTrendsData() {
        try {
            // while(trendsData.size() == 0 ){
            System.out.println("Start browser");
            driver.get("https://trends.google.us/trends/trendingsearches/realtime?geo=US&category=all");
            Thread.sleep(7000);
            System.out.println("Page downloading");
            //WebElement mainBlock = wait.until(presenceOfElementLocated(By.className(SELECTOR_MAIN_BLOCK)));
            List<WebElement> elements = driver.findElements(By.className(SELECTOR_ITEMS));
            for (WebElement element : elements){
                WebElement block  = element.findElement(By.xpath(".//div[@class=\'" + SELECTOR_BLOCK + "\']//a"));
                String rank = element.findElement(By.xpath(".//div[@class=\'" + SELECTOR_RANK_CHILD + "\']")).getText();
                String url = block.getAttribute("href");
                String title = block.getText();
                List<String> keyWords = new ArrayList<>();
                List<WebElement> keyWordElements = element.findElements(By.xpath(".//div[@class=\'" + SELECTOR_KEYWORDS + "\']//span//a"));
                for (WebElement keyWordElement : keyWordElements){
                    String text = keyWordElement.getText();
                    if (!"".equals(text))
                    keyWords.add(text); 
                }
                count++;
                node = new RealtimeNode();
                node.fillNode(rank, url, title, keyWords);
                trendsData.add(node.getNode());
            }
            
        } catch (Exception e) {
            driver.quit();
            e.printStackTrace();
        } finally {
            System.out.println("Trends download: " + count + " url");
        //    driver.quit();
        }
    }

    public List<RealtimeNode> getTrendsData(){
        return trendsData;
    }
}
