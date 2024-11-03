package com.klakson4ik;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.WebDriverWait;
import java.time.Duration;

import java.util.List;
import java.util.ArrayList;

public class ExecuteTrends extends InitDriver{
    final private String SELECTOR_MAIN_BLOCK = "homepage-trending-stories";
    final private String SELECTOR_ITEMS = "feed-item-header";
    final private String SELECTOR_KEYWORDS = "details-top";
    final private String SELECTOR_RANK_CHILD = "index";
    final private String SELECTOR_BLOCK = "summary-text";
    final private String SELECTOR_LOAD_MORE = "feed-load-more-button";
    private byte count = 0;
    private String[] dataLink;
    private int countUrl; 

    public ExecuteTrends(List<String[]> dataLinks){
        super();
        for(String[] dataLink : dataLinks){
            this.dataLink = dataLink;
            count = 0;
            countUrl = Integer.parseInt(dataLink[1].trim());
            createTrendsData();
        }
        System.out.println("Trends download: " + count + " url");
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            System.out.println("Start browser");
            boolean is_true = true;
            byte countLoad = 0;
            while(is_true == true){
                if(countLoad == 5)
                    break;
                try{
                    System.out.println("Zashel");
                    driver.get(dataLink[0]);
                    System.out.println("Vipolnel");
                    is_true = false;
                }catch(Exception ex){
                    System.out.println("Ne - Vipolnel");
                    Thread.sleep(2000);
                    ++countLoad;
                }
            }
            wait.until(ExpectedConditions.elementToBeClickable(By.className(SELECTOR_LOAD_MORE)));
            System.out.println("Page downloading");
            List<WebElement> elements = driver.findElements(By.className(SELECTOR_ITEMS));
            while(elements.size() <= countUrl){
                WebElement loadMore = wait.until(ExpectedConditions.elementToBeClickable(By.className(SELECTOR_LOAD_MORE)));
                loadMore.click();
                elements = driver.findElements(By.className(SELECTOR_ITEMS));
            }
            consistNode(elements);
        } catch (Exception e) {
            driver.quit();
            e.printStackTrace();
        }
    }
    
    private void consistNode(List<WebElement> elements){
        for (WebElement element : elements){
            WebElement block  = element.findElement(By.xpath(".//div[@class=\'" + SELECTOR_BLOCK + "\']//a"));
            String rank = element.findElement(By.xpath(".//div[@class=\'" + SELECTOR_RANK_CHILD + "\']")).getText();
            String url = block.getAttribute("href");
            String title = block.getText();
            List<String> keyWords = new ArrayList<>();
            WebElement arrowDown = element.findElement(By.className("rotate-down"));
            arrowDown.click();
            List<WebElement> keyWordElements = driver.findElements(By.className("chip"));
            for (WebElement keyWordElement : keyWordElements){
                String text = keyWordElement.getText();
                if (!"".equals(text))
                keyWords.add(text); 
            }
            WebElement arrowUp = element.findElement(By.className("rotate-up"));
            arrowUp.click();
            count++;
            node = new Node();
            node.fillNode(rank, url, title, keyWords);
            TrendsData.setData(node.getNode());
            if(count >= countUrl){
                break;
            }
        }
    }
}
