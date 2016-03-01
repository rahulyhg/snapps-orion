<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="Simple responsive css framework">
    <meta name="author" content="Sergey S. Pimenov, Ukraine, Kiev">

    <link href="css/metro-bootstrap.css" rel="stylesheet">
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="css/iconFont.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/load-metro.js"></script>

    <!-- Local JavaScript -->
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>

    <title>Metro UI CSS : Metro Bootstrap CSS Library</title>
</head>
<body class="metro">
    <header class="bg-dark" data-load="header.html"></header>
    <div class="container">
        <h1>
            <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            Navigation Bar<small class="on-right">component</small>
        </h1>

        <p class="description">
            Navigation Bar is represented navigation component for creating menu.
        </p>

        <div class="example">
            <div class="navbar">
                <div class="navbar-content">

                    <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <li>
                            <a class="dropdown-toggle" href="#">Base CSS</a>
                            <ul class="dropdown-menu" data-role="dropdown">
                                <li><a href="requirements.html">Requirements</a></li>
                                <li>
                                    <a href="#" class="dropdown-toggle">General CSS</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="global.html">Global styles</a></li>
                                        <li><a href="grid.html">Grid system</a></li>
                                        <div class="divider"></div>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="forms.html">Forms</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="images.html">Images</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="responsive.html">Responsive</a></li>
                                <li class="disabled"><a href="layouts.html">Layouts and templates</a></li>
                                <li class="divider"></li>
                                <li><a href="icons.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle"  href="#">Community</a>
                            <ul class="dropdown-menu" data-role="dropdown">
                                <li class="disabled"><a href="http://blog.metroui.net">Blog</a></li>
                                <li class="disabled"><a href="http://forum.metroui.net">Community Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS">Github</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS/blob/master/LICENSE">License</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="no-tablet-portrait">
                        <span class="element-divider"></span>
                        <a class="element brand" href="#"><span class="icon-spin"></span></a>
                        <a class="element brand" href="#"><span class="icon-printer"></span></a>
                        <span class="element-divider"></span>

                        <div class="element input-element">
                            <form>
                                <div class="input-control text">
                                    <input type="text" placeholder="Search...">
                                    <button class="btn-search"></button>
                                </div>
                            </form>
                        </div>

                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <span class="icon-cog"></span>
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Download</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Buy Now</a></li>
                            </ul>
                        </div>
                        <span class="element-divider place-right"></span>
                        <button class="element image-button image-left place-right">
                            Sergey Pimenov
                            <img src="images/me.jpg"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
<pre class="prettyprint linenums">
&lt;nav class="navigation-bar dark"&gt;
    &lt;nav class="navigation-bar-content"&gt;
        &lt;item class="element"&gt;...&lt;/item&gt;
        &lt;item class="element-divider"&gt;...&lt;/item&gt;
        ...
        &lt;item class="element"&gt;...&lt;/item&gt;
    &lt;/nav&gt;
&lt;/nav&gt;
</pre>
        <p>
            Navigator Bar <strong>element</strong> can be: <code>&lt;a&gt;</code>, <code>&lt;div&gt;</code>,  <code>&lt;span&gt;</code>, etc.
            Complex element (example input-control) must be included in <code>div</code> with <code>.element</code> class.
            For creating divider you must add <code>span</code> with <code>.element-divider</code> class.
            For placing element right you must add class <code>.place-right</code> to element.
        </p>
<pre class="prettyprint linenums">
&lt;nav class="navigation-bar"&gt;
    &lt;nav class="navigation-bar-content"&gt;
        &lt;div class="element"&gt;
            &lt;a class="dropdown-toggle" href="#"&gt;METRO UI CSS&lt;/a&gt;
            &lt;ul class="dropdown-menu" data-role="dropdown"&gt;
                &lt;li&gt;&lt;a href="#"&gt;Main&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;File Open&lt;/a&gt;&lt;/li&gt;
                &lt;li class="divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Print...&lt;/a&gt;&lt;/li&gt;
                &lt;li class="divider"&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Exit&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;

        &lt;span class="element-divider"&gt;&lt;/span&gt;
        &lt;a class="element brand" href="#"&gt;&lt;span class="icon-spin"&gt;&lt;/span&gt;&lt;/a&gt;
        &lt;a class="element brand" href="#"&gt;&lt;span class="icon-printer"&gt;&lt;/span&gt;&lt;/a&gt;
        &lt;span class="element-divider"&gt;&lt;/span&gt;

        &lt;div class="element input-element"&gt;
            &lt;form&gt;
                &lt;div class="input-control text"&gt;
                    &lt;input type="text" placeholder="Search..."&gt;
                    &lt;button class="btn-search"&gt;&lt;/button&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;

        &lt;div class="element place-right"&gt;
            &lt;a class="dropdown-toggle" href="#"&gt;
                &lt;span class="icon-cog"&gt;&lt;/span&gt;
            &lt;/a&gt;
            &lt;ul class="dropdown-menu place-right" data-role="dropdown"&gt;
                &lt;li&gt;&lt;a href="#"&gt;Products&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Download&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Support&lt;/a&gt;&lt;/li&gt;
                &lt;li&gt;&lt;a href="#"&gt;Buy Now&lt;/a&gt;&lt;/li&gt;
            &lt;/ul&gt;
        &lt;/div&gt;
        &lt;span class="element-divider place-right"&gt;&lt;/span&gt;
        &lt;a class="element place-right" href="#"&gt;&lt;span class="icon-locked-2"&gt;&lt;/span&gt;&lt;/a&gt;
        &lt;span class="element-divider place-right"&gt;&lt;/span&gt;
        &lt;button class="element image-button image-left place-right"&gt;
            Sergey Pimenov
            &lt;img src="images/211858_100001930891748_287895609_q.jpg"/&gt;
        &lt;/button&gt;
    &lt;/nav&gt;
&lt;/nav&gt;
</pre>

        <p>
            You can create fixed (top or bottom) navigation bar with built in subclasses <code>.fixed-top</code>, <code>.fixed-bottom</code>.
        </p>
<pre class="prettyprint linenums">
&lt;nav class="navigation-bar fixed-top"&gt;...&lt;/nav&gt;
&lt;nav class="navigation-bar fixed-bottom"&gt;...&lt;/nav&gt;
</pre>

        <h3>Themed navigation-bar</h3>
        <div class="example">
            <h3>Default</h3>
            <nav class="navigation-bar">
                <div class="navigation-bar-content">
                    <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <li>
                            <a class="dropdown-toggle" href="#">Base CSS</a>
                            <ul class="dropdown-menu " data-role="dropdown">
                                <li><a href="requirements.html">Requirements</a></li>
                                <li>
                                    <a href="#" class="dropdown-toggle">General CSS</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="global.html">Global styles</a></li>
                                        <li><a href="grid.html">Grid system</a></li>
                                        <div class="divider"></div>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="forms.html">Forms</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="images.html">Images</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="responsive.html">Responsive</a></li>
                                <li class="disabled"><a href="layouts.html">Layouts and templates</a></li>
                                <li class="divider"></li>
                                <li><a href="icons.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle"  href="#">Community</a>
                            <ul class="dropdown-menu" data-role="dropdown">
                                <li class="disabled"><a href="http://blog.metroui.net">Blog</a></li>
                                <li class="disabled"><a href="http://forum.metroui.net">Community Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS">Github</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS/blob/master/LICENSE">License</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="no-tablet-portrait">
                        <span class="element-divider"></span>
                        <a class="element brand" href="#"><span class="icon-spin"></span></a>
                        <a class="element brand" href="#"><span class="icon-printer"></span></a>
                        <span class="element-divider"></span>

                        <div class="element input-element">
                            <form>
                                <div class="input-control text">
                                    <input type="text" placeholder="Search...">
                                    <button class="btn-search"></button>
                                </div>
                            </form>
                        </div>

                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <span class="icon-cog"></span>
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Download</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Buy Now</a></li>
                            </ul>
                        </div>
                        <span class="element-divider place-right"></span>
                        <button class="element image-button image-left place-right">
                            Sergey Pimenov
                            <img src="images/me.jpg"/>
                        </button>
                    </div>
                </div>
            </nav>
            <h3>Dark</h3>
            <nav class="navigation-bar dark">
                <div class="navigation-bar-content">
                    <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <li>
                            <a class="dropdown-toggle" href="#">Base CSS</a>
                            <ul class="dropdown-menu dark" data-role="dropdown">
                                <li><a href="requirements.html">Requirements</a></li>
                                <li>
                                    <a href="#" class="dropdown-toggle">General CSS</a>
                                    <ul class="dropdown-menu dark" data-role="dropdown">
                                        <li><a href="global.html">Global styles</a></li>
                                        <li><a href="grid.html">Grid system</a></li>
                                        <div class="divider"></div>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="forms.html">Forms</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="images.html">Images</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="responsive.html">Responsive</a></li>
                                <li class="disabled"><a href="layouts.html">Layouts and templates</a></li>
                                <li class="divider"></li>
                                <li><a href="icons.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle"  href="#">Community</a>
                            <ul class="dropdown-menu dark" data-role="dropdown">
                                <li class="disabled"><a href="http://blog.metroui.net">Blog</a></li>
                                <li class="disabled"><a href="http://forum.metroui.net">Community Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS">Github</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS/blob/master/LICENSE">License</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="no-tablet-portrait">
                        <span class="element-divider"></span>
                        <a class="element brand" href="#"><span class="icon-spin"></span></a>
                        <a class="element brand" href="#"><span class="icon-printer"></span></a>
                        <span class="element-divider"></span>

                        <div class="element input-element">
                            <form>
                                <div class="input-control text">
                                    <input type="text" placeholder="Search...">
                                    <button class="btn-search"></button>
                                </div>
                            </form>
                        </div>

                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <span class="icon-cog"></span>
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Download</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Buy Now</a></li>
                            </ul>
                        </div>
                        <span class="element-divider place-right"></span>
                        <button class="element image-button image-left place-right">
                            Sergey Pimenov
                            <img src="images/me.jpg"/>
                        </button>
                    </div>
                </div>
            </nav>
            <h3>Light</h3>
            <nav class="navigation-bar light">
                <div class="navigation-bar-content">
                    <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <li>
                            <a class="dropdown-toggle" href="#">Base CSS</a>
                            <ul class="dropdown-menu inverse" data-role="dropdown">
                                <li><a href="requirements.html">Requirements</a></li>
                                <li>
                                    <a href="#" class="dropdown-toggle">General CSS</a>
                                    <ul class="dropdown-menu inverse" data-role="dropdown">
                                        <li><a href="global.html">Global styles</a></li>
                                        <li><a href="grid.html">Grid system</a></li>
                                        <div class="divider"></div>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="forms.html">Forms</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="images.html">Images</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="responsive.html">Responsive</a></li>
                                <li class="disabled"><a href="layouts.html">Layouts and templates</a></li>
                                <li class="divider"></li>
                                <li><a href="icons.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle"  href="#">Community</a>
                            <ul class="dropdown-menu inverse" data-role="dropdown">
                                <li class="disabled"><a href="http://blog.metroui.net">Blog</a></li>
                                <li class="disabled"><a href="http://forum.metroui.net">Community Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS">Github</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS/blob/master/LICENSE">License</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="no-tablet-portrait">
                        <span class="element-divider"></span>
                        <a class="element brand" href="#"><span class="icon-spin"></span></a>
                        <a class="element brand" href="#"><span class="icon-printer"></span></a>
                        <span class="element-divider"></span>

                        <div class="element input-element">
                            <form>
                                <div class="input-control text">
                                    <input type="text" placeholder="Search...">
                                    <button class="btn-search"></button>
                                </div>
                            </form>
                        </div>

                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <span class="icon-cog"></span>
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Download</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Buy Now</a></li>
                            </ul>
                        </div>
                        <span class="element-divider place-right"></span>
                        <button class="element image-button image-left place-right">
                            Sergey Pimenov
                            <img src="images/me.jpg"/>
                        </button>
                    </div>
                </div>
            </nav>
            <h3>White</h3>
            <nav class="navigation-bar white border">
                <div class="navigation-bar-content">
                    <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <li>
                            <a class="dropdown-toggle" href="#">Base CSS</a>
                            <ul class="dropdown-menu" data-role="dropdown">
                                <li><a href="requirements.html">Requirements</a></li>
                                <li>
                                    <a href="#" class="dropdown-toggle">General CSS</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="global.html">Global styles</a></li>
                                        <li><a href="grid.html">Grid system</a></li>
                                        <div class="divider"></div>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="forms.html">Forms</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="images.html">Images</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="responsive.html">Responsive</a></li>
                                <li class="disabled"><a href="layouts.html">Layouts and templates</a></li>
                                <li class="divider"></li>
                                <li><a href="icons.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle"  href="#">Community</a>
                            <ul class="dropdown-menu" data-role="dropdown">
                                <li class="disabled"><a href="http://blog.metroui.net">Blog</a></li>
                                <li class="disabled"><a href="http://forum.metroui.net">Community Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS">Github</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS/blob/master/LICENSE">License</a></li>
                            </ul>
                        </li>
                    </ul>

                    <div class="no-tablet-portrait">
                        <span class="element-divider"></span>
                        <a class="element brand" href="#"><span class="icon-spin"></span></a>
                        <a class="element brand" href="#"><span class="icon-printer"></span></a>
                        <span class="element-divider"></span>

                        <div class="element input-element">
                            <form>
                                <div class="input-control text">
                                    <input type="text" placeholder="Search...">
                                    <button class="btn-search"></button>
                                </div>
                            </form>
                        </div>

                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <span class="icon-cog"></span>
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Download</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Buy Now</a></li>
                            </ul>
                        </div>
                        <span class="element-divider place-right"></span>
                        <button class="element image-button image-left place-right">
                            Sergey Pimenov
                            <img src="images/me.jpg"/>
                        </button>
                    </div>
                </div>
            </nav>
        </div>
<pre class="prettyprint linenums">
&lt;nav class="navigation-bar dark"&gt;...&lt;/nav&gt;
&lt;nav class="navigation-bar light"&gt;...&lt;/nav&gt;
&lt;nav class="navigation-bar white"&gt;...&lt;/nav&gt;
</pre>

        <h3 id="drop-up-menu">Drop-up menu</h3>
        <p>
            For navigation bar, located at the bottom of the page may need to disclose the possibility of up menu.
            Metro UI CSS gives you this opportunity. To do this you need to add to the <code>element-menu</code> class <code>drop-up</code>
        </p>
<pre class="prettyprint linenums">
&lt;nav class="navigation-bar fixed-bottom"&gt;
    &lt;ul class="element-menu drop-up"&gt;
        ...
    &lt;/ul&gt;
&lt;/nav&gt;
</pre>

        <div class="example">
            <div class="navigation-bar">
                <div class="navigation-bar-content">
                    <a href="/" class="element"><span class="icon-grid-view"></span> METRO UI CSS <sup>2.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu drop-up">
                        <li>
                            <a class="dropdown-toggle" href="#">Base CSS</a>
                            <ul class="dropdown-menu " data-role="dropdown">
                                <li><a href="requirements.html">Requirements</a></li>
                                <li>
                                    <a href="#" class="dropdown-toggle">General CSS</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="global.html">Global styles</a></li>
                                        <li><a href="grid.html">Grid system</a></li>
                                        <div class="divider"></div>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="tables.html">Tables</a></li>
                                        <li><a href="forms.html">Forms</a></li>
                                        <li><a href="buttons.html">Buttons</a></li>
                                        <li><a href="images.html">Images</a></li>
                                    </ul>
                                </li>
                                <li class="divider"></li>
                                <li><a href="responsive.html">Responsive</a></li>
                                <li class="disabled"><a href="layouts.html">Layouts and templates</a></li>
                                <li class="divider"></li>
                                <li><a href="icons.html">Icons</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle"  href="#">Community</a>
                            <ul class="dropdown-menu" data-role="dropdown">
                                <li class="disabled"><a href="http://blog.metroui.net">Blog</a></li>
                                <li class="disabled"><a href="http://forum.metroui.net">Community Forum</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS">Github</a></li>
                                <li class="divider"></li>
                                <li><a href="https://github.com/olton/Metro-UI-CSS/blob/master/LICENSE">License</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

    </div>

    <script src="js/hitua.js"></script>

</body>
</html>