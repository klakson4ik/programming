package com.klakson4ik;

import org.openqa.selenium.By;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.WebDriverWait;
import static org.openqa.selenium.support.ui.ExpectedConditions.presenceOfElementLocated;
import java.time.Duration;
//import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.NoSuchElementException;
import java.lang.InterruptedException;
import java.net.URL;
import java.net.MalformedURLException;
import java.util.Timer;
import java.util.TimerTask;


import de.l3s.boilerpipe.BoilerpipeExtractor;
import de.l3s.boilerpipe.BoilerpipeProcessingException;
import de.l3s.boilerpipe.document.Media;
import de.l3s.boilerpipe.extractors.CommonExtractors;
import de.l3s.boilerpipe.sax.HtmlArticleExtractor;
import de.l3s.boilerpipe.sax.MediaExtractor;
import java.io.IOException;
import org.xml.sax.SAXException;
import java.net.URISyntaxException;

import java.util.List;
import java.util.ArrayList;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.Executors;
import java.util.concurrent.Future;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;
import java.lang.Runnable;
import java.lang.Runtime;
import org.openqa.selenium.WindowType;
import java.lang.Thread;
import java.util.regex.Pattern;

public class RealtimeContent extends Realtime {
    private static int core;
    private Thread task;
    private Thread myTimer;

    {
        core = Runtime.getRuntime().availableProcessors() + 1;
    }

    public RealtimeContent(){
        createTrendsContent();
    }

    private void createTrendsContent() {
        myTimer = new Thread(new MyTimer(), "MyTimer");
        myTimer.start();
        for (RealtimeNode node : trendsData){
            task = new Thread(new Task(node), "Task");
            task.start();
        //  threadPool.submit(new ThreadNode(node));
        // threadPool.shutdown();
//      driver.quit();
//      System.out.println("Stop Browser");
        }
        //myTimer.interrupt();
        try{
            myTimer.join(5000);
            myTimer.interrupt();
            task.stop();
        }catch(InterruptedException e){
            e.printStackTrace();
        }
        catch (Exception e) {
            driver.quit();
            e.printStackTrace();
        }
    }

    private class Task implements Runnable{
        private RealtimeNode node;
        public Task(RealtimeNode node){
            this.node = node;
        }
        public void run(){
        //  myTimer = new Thread(new MyTimer(), "MyTimer");
        //  myTimer.start();
            boilerpipe(node);
        //  myTimer.interrupt();
        }
    }

    private class MyTimer implements Runnable{
        private int time = 0;
        // private Task task;
        // public MyTimer(Task task){
        //  this.task = task;
        // }
        public void run(){
            try{
                while(!myTimer.isInterrupted()){
                    Thread.sleep(100);
                }
            }catch(InterruptedException e){
            }
        }
    }

    private void boilerpipe(RealtimeNode node){
        if(!"".equals(node.getUrl())){
            System.out.println("Page downloading " + node.getUrl());
            try{
                URL url = new URL(node.getUrl());
                final BoilerpipeExtractor extractor = CommonExtractors.ARTICLE_EXTRACTOR;
                final HtmlArticleExtractor htmlExtr = HtmlArticleExtractor.INSTANCE;
                // myTimer = new Thread(new MyTimer(), "MyTimer");
                // myTimer.start();
                String text = htmlExtr.process(extractor, url);
//              myTimer.interrupt();
                if(text.length() > 200){
                    node.setText(text);
                    // new ModelDB().storeDB(node);
                }else{
                    trendsData.remove(node);
                }
                return;
            }
            catch(IOException e) {
            //  e.printStackTrace();
            }
            catch(BoilerpipeProcessingException e) {
                e.printStackTrace();
            }
            catch(SAXException e) {
                e.printStackTrace();
            }
            catch(URISyntaxException e){
                e.printStackTrace();
            // }catch(MalformedURLException e) {
            //  e.printStackTrace();
            // }
            }
        }
    }
}






