# как установить?

1.) открыть терминал / командную строку

2.) перейти в директорию проекта

> cd ../your_project/src

3.) клонировать фреймворк

> git clone https://github.com/wai-wafm/wafm.git

4.) добавить в главную форму код

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        WebServerBuilder::run();
        new WebPreloader();
        new WebAppBuilder(); 

    }
    
    /**
     * @event close 
     */
    function doClose(UXWindowEvent $e = null)
    {    
        exit();
    }
    
5.) в вашу главную форму добавить объект "web browser" по размеру формы 

6.) добавить необходимые настройки для браузера

> растягивание - все 

> видимость и доступность

7.) указать обязательно ID (по умолчанию в настройках фреймворк):

> web

8.) указать обязательно URL (по умолчанию в настройках фреймворк):

> http://localhost:8000/index.html

9.) добавить первый файл шаблона index.html

> res://wafm/app/html/index.html