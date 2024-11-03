package com.klakson4ik;

public class BoilerPipeFactory {
    public static void main(){
        IBoilerPipeFactory factory = new BoilerPipeProdFactory();
        factory.create();
    }
}

interface IBoilerPipeFactory{
   void create(); 
}

class BoilerPipeProdFactory implements IBoilerPipeFactory{
    public void create(){
        new BoilerPipe();
    }
}

class BoilerPipeDevFactory implements IBoilerPipeFactory{
    public void create(){
        new BoilerPipeDev();
    }
}
