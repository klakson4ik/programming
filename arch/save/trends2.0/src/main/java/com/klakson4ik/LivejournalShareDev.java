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

public class LivejournalShareDev extends InitDriver{
    final private String LIVEJOURNAL_URL = "https://www.livejournal.com";
    final private String EMAIL = "gonomax";
    final private String PASSWORD = "Ntktdbpjh59!";
    final private String SHARE_URL = "/sharer.php?u=https%3A%2F%2Fgonomax.com%2Fnews%2Findex%3Fid%3D";
    final private String ID = "6060";

    public LivejournalShareDev(){
        super();
        System.out.println("Livejournal download");
        createTrendsData();
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            driver.manage().timeouts().pageLoadTimeout(30000, TimeUnit.MILLISECONDS);
            driver.get(LIVEJOURNAL_URL + "/login.bml");
            WebElement email = wait.until(presenceOfElementLocated(By.id("user")));
            email.sendKeys(EMAIL + Keys.TAB + PASSWORD, Keys.TAB, Keys.TAB, Keys.TAB, Keys.ENTER);
            driver.findElement(By.xpath("//button[contains(text(), \"Save\")]"));
            driver.get(LIVEJOURNAL_URL + "/update.bml?subject=49ers signing LB Mychal Kendricks, per report&event=%3Cimg%20src=%22https://cdn.vox-cdn.com/uploads/chorus_asset/file/22781855/usa_today_13655917.jpg%22%3E%0A%3Ch1%3Edescription%20%3Ca%20href=%22https://gonomax.com%22%3Eread%20more...%3C/a%3E%3C/h1%3E");
            WebElement buttonShare = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//span[contains(text(), \"Tune in and publish\")]/parent::button")));
            buttonShare.click();
            WebElement buttonPublish = wait.until(ExpectedConditions.elementToBeClickable(By.xpath("//span[contains(text(), \"Publish\")]")));
            // buttonPublish.click();
            // WebElement buttonPlus = wait.until(presenceOfElementLocated(By.className("_14q")));
            // buttonPlus.click();
            // driver.findElement(By.id("lj_loginwidget_password")).sendKeys(PASSWORD + Keys.TAB + Keys.ENTER);
            // driver.findElement(By.id("email")).sendKeys(EMAIL + Keys.TAB + PASSWORD + Keys.TAB + Keys.ENTER);        

                // driver.get(FB_URL + SHARE_URL + ID);
                // wait.until(ExpectedConditions.elementToBeClickable(By.className(SELECTOR_BUTTON_SHARE)));
                // driver.findElement(By.tagName("body")).sendKeys("DESCRIPTION" + Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.TAB, Keys.ENTER);
            // wait.until(presenceOfElementLocated(By.className("sidebarMode")));
                Thread.sleep(30000);
        } catch (Exception e) {
            e.printStackTrace();
            driver.quit();
        }
    }
}
