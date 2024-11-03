package com.klakson4ik;

import java.util.List;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.WebDriverWait;
import java.time.Duration;

public abstract class Init {
    protected Node node;

    abstract protected void createTrendsData();

}

abstract class InitDriver extends Init {
    protected RemoteWebDriver driver;
    protected WebDriverWait wait;

    public InitDriver(){
        Config config = new Config();
        driver = config.getDriver();
        wait = new WebDriverWait(driver, Duration.ofSeconds(20));
    }

    abstract protected void createTrendsData();

}
