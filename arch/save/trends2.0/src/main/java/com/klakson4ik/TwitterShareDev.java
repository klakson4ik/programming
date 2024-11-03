package com.klakson4ik;

import org.openqa.selenium.By;
import java.net.URL;
import java.net.MalformedURLException;
import java.net.URISyntaxException;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.interactions.Actions;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import static org.openqa.selenium.support.ui.ExpectedConditions.visibilityOfElementLocated;
import java.time.Duration;
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.util.Set;
import org.openqa.selenium.interactions.Actions;
import org.openqa.selenium.support.ui.ExpectedConditions;

import java.util.List;
import java.util.ArrayList;
 import java.io.FileOutputStream;
 import java.io.IOException;
 import java.io.InputStream;
 import java.io.OutputStream;
 import org.openqa.selenium.WindowType;
 import java.util.concurrent.TimeUnit;

public class TwitterShareDev extends InitDriver{
    final private String TWITTER_URL = "https://twitter.com/";
    final private String EMAIL = "gonomaxnews";
    final private String PASSWORD = "Ntktdbpjh59!";
    final private String TWITTER_DIV_ID = "react-root";
    final private String SELECTOR_BUTTON_SHARE = "layerConfirm";
    final private String SHARE_URL = "/sharer.php?u=https://gonomax.com/news/index?id=";
    final private String ID = "4567";

    public TwitterShareDev(){
        super();
        System.out.println("Twitter download");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.get(TWITTER_URL + "login");
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'Log in')]")));
            driver.findElement(By.tagName("html")).sendKeys(Keys.TAB, EMAIL + Keys.TAB + PASSWORD + Keys.TAB + Keys.ENTER);        
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'Home')]")));

            driver.get("https://twitter.com/intent/tweet?text=Bellator 263 live results -- Patricio Pitbull vs. AJ McKee: Fight card, highlights, updates, start time&url=https://gonomax.com/news/index?id=5971&via=gonomax&hashtags=Ufc268,UriahHall,Bellator,Bellator263,EvanderKane");
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'gonomax.com')]")));
                // driver.findElement(By.tagName("body")).sendKeys("DESCRIPTION" + Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.ENTER);
            driver.findElement(By.xpath("//span[contains(text(), 'Tweet')]")).click();
            // wait.until(presenceOfElementLocated(By.className("sidebarMode")));
            driver.get("https://twitter.com/intent/tweet?text=Bellator 263 live results -- Patricio Pitbull vs. AJ McKee: Fight card, highlights, updates, start time&url=https://gonomax.com/news/index?id=5971&via=gonomax&hashtags=Ufc268,UriahHall,Bellator,Bellator263,EvanderKane");
            wait.until(presenceOfElementLocated(By.xpath("//span[contains(text(), 'gonomax.com')]")));
                // driver.findElement(By.tagName("body")).sendKeys("DESCRIPTION" + Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.ENTER);
            driver.findElement(By.xpath("//span[contains(text(), 'Tweet')]")).click();
                Thread.sleep(5000);
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
    }
}
