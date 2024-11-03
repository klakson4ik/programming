package com.klakson4ik;

public class ImagesFactory {
    public static void main(){
        IImagesFactory factory = new ImagesProdFactory();
        factory.create();
    }
}

interface IImagesFactory{
   void create(); 
}

class ImagesProdFactory implements IImagesFactory{
    public void create(){
        new Images();
    }
}

class ImagesDevFactory implements IImagesFactory{
    public void create(){
        new ImagesDev();
    }
}


