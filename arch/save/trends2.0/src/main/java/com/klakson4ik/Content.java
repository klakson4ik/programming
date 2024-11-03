package com.klakson4ik;

import java.util.List;
import java.util.ArrayList;

public class Content {
    
    public void start(){
        // ImagesFactory.main();
         // BoilerPipeFactory.main();
        Links links = new Links();
        List<String[]> dataLinks = links.getDataLinks();
        //for(String[] dataLink : dataLinks){
           IStep stepping = new StoreAll(new ConnectTextImages(new FillImages(new FillText(new CheckExist(new ExecuteUrl(dataLinks))))));
           // IStep stepping = new ConnectTextImages(new FillImages(new FillText(new CheckExist(new ExecuteUrl(dataLink)))));
           //IStep stepping = new FillImages();
           stepping.interact();
        //}
    }
} 

interface IStep{
    void interact();
}

class ExecuteUrl implements IStep {
    private List<String[]> dataLinks;

    public ExecuteUrl(List<String[]> dataLinks){
        this.dataLinks = dataLinks;
    }
    @Override
    public void interact(){
        new ExecuteTrends(dataLinks);
    }
}

abstract class Decorator implements IStep{
    IStep step;
    public Decorator(IStep step){
        this.step = step;
    }
    @Override
    public void interact(){
        step.interact();
        addAction();
    }

    abstract protected void addAction();
}

class CheckExist extends Decorator{
    public CheckExist(IStep step){
        super(step);
    }
     @Override
     protected void addAction(){
        new CheckExistNewsInDB();        
     }
}

class FillText extends Decorator{
    public FillText(IStep step){
        super(step);
    }
     @Override
     protected void addAction(){
        new TextContent();        
     }
}

class FillImages extends Decorator{

    public FillImages(IStep step){
        super(step);
    }
     @Override
     protected void addAction(){
        ImagesFactory.main();        
     }
}

class ConnectTextImages extends Decorator{
    public ConnectTextImages(IStep step){
        super(step);
    }
     @Override
     protected void addAction(){
        BoilerPipeFactory.main();        
     }
}

class StoreAll extends Decorator{
    public StoreAll(IStep step){
        super(step);
    }
     @Override
     protected void addAction(){
        new StoreContent();        
     }
}
