package com.klakson4ik;

import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.WebDriverWait;
import java.time.Duration;

import java.util.List;
import java.util.ArrayList;
import java.util.concurrent.TimeUnit;

public abstract class Init {
    protected RemoteWebDriver driver;
    protected List<RealtimeNode> trendsData;
    protected WebDriverWait wait;
    protected RealtimeNode node;

    {
        driver = new Config().getDriver();
        wait = new WebDriverWait(driver, Duration.ofSeconds(20));
        driver.manage().timeouts().pageLoadTimeout(20, TimeUnit.SECONDS);
    }

}
