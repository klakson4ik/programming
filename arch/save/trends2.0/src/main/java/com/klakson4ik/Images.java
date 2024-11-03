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
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfAllElementsLocatedBy;
import static org.openqa.selenium.support.ui.ExpectedConditions.visibilityOfElementLocated;
import java.time.Duration;
import java.util.regex.Pattern;
import java.util.regex.Matcher;

import java.util.List;
import java.util.ArrayList;
 import java.io.FileOutputStream;
 import java.io.IOException;
 import java.io.InputStream;
 import java.io.OutputStream;

public class Images extends InitDriver{
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

    public Images(){
        super();
        System.out.println("Images page download");
        createTrendsData();
        System.out.println("Images save");
        driver.quit();
    }

    protected void createTrendsData() {
        try {
            for (Node node : TrendsData.getList()){
                driver.get("https://www.google.com/search?q=" + node.getTitle());
                String imagesUrl = driver.findElement(By.xpath("//a[text()=\'" + SELECTOR_URL  +"\']")).getAttribute("href");        
                driver.get(imagesUrl);
                block = wait.until(presenceOfElementLocated(By.xpath("//div[@id=\'" + SELECTOR_BLOCK  + "\']")));
                imagesBlock = new ArrayList<WebElement>();
                wait.until(presenceOfElementLocated(By.className(SELECTOR_IMAGES_BLOCK)));
                imagesBlock = driver.findElements(By.className(SELECTOR_IMAGES_BLOCK));
                images = new ArrayList<String>();
                imagesFull = new ArrayList<String>();
                imagesAlt = new ArrayList<String>();
                byte count = 0;
                String https = "https://";
                Pattern httpsP = Pattern.compile(https, Pattern.CASE_INSENSITIVE);
                for (WebElement imageBlock : imagesBlock){
                    if(count == 5){
                        break;
                    }
                    imageBlock.findElement(By.xpath("./parent::div/parent::a")).click();
                    WebElement imageFullBlock = wait.until(presenceOfElementLocated(By.className(SELECTOR_IMAGES_FULL_BLOCK)));
                    String imageFullSrc = imageFullBlock.findElement(By.className(SELECTOR_IMAGES_FULL)).getAttribute("src");
                    if(!httpsP.matcher(imageFullSrc).find()){
                        continue;
                    }
                    String imageFinalImageSrc = imageFullSrc;
                    if(count == 0){
                        imageFinalImageSrc = editImageUrl(imageFullSrc);
                        if(imageFinalImageSrc == null){
                            continue;
                        }
                    }
                    System.out.println(imageFinalImageSrc);
                    images.add(imageBlock.getAttribute("src"));
                    imagesAlt.add(imageBlock.getAttribute("alt"));
                    imagesFull.add(imageFinalImageSrc);
                    count++;
                }
                node.setImages(images);
                node.setImagesAlt(imagesAlt);
                node.setImagesFull(imagesFull);
            }
        } catch (Exception e) {
            // driver.quit();
            e.printStackTrace();
        }
    }

    private String editImageUrl(String url){
        String finalUrl = "";
        String prop = Props.getProp("dns-suffixes");
        String[] suffixes = prop.split(",");
        for(String suffix : suffixes){
            String domain = "\\b." + suffix + "\\b";
            Pattern p = Pattern.compile(domain);
            Matcher m = p.matcher(url);
            Pattern urlPattern = Pattern.compile("(?<!/)/[A-Za-z0-9-_.]+\\b" + domain +  "\\b.+");
            byte count = 0;
            while(m.find()){
                String b =  m.group();
                ++count;
                if(count > 1){
                    System.out.println("Double Url image");
                    Matcher t = urlPattern.matcher(url);
                    while(t.find()){
                        String g = t.group();
                        try{
                            System.out.println("probuem cut url address ");
                            URL urlIm = new URL("https:/" + g);
                            InputStream is = urlIm.openStream();
                            System.out.println("Open cut double url image ");
                            return "https:/" + g;
                        }
                        catch(MalformedURLException e){
                            System.out.println("Doesn't open Cut url and double url image(URLEx)");
                            return null;
                        }
                        catch(IOException e){
                            try{
                                URL urlEx = new URL(url);
                                InputStream isEx  = urlEx.openStream();
                                System.out.println("Open double url image");
                                return url;
                            }catch (IOException ex){
                                System.out.println("Doesn't open cut url and double url image");
                                return null;
                            }
                        }
                    }
                }
            }
        }
        try{
            URL urlEx = new URL(url);
            InputStream isEx  = urlEx.openStream();
            System.out.println("Open url image");
            return url;
        }catch(MalformedURLException e){
            System.out.println("Doesn't open url image(URLEx)");
            return null;
        }catch (IOException ex ){
            System.out.println("Doesn't open url image");
            return null;
        }
    }
}
