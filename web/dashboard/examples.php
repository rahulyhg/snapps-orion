<!DOCTYPE html>
<html>
<?php include_once 'header.php';?>
<body class="metro">
    <header class="bg-dark" data-load="header.html"></header>

    <div class="container">
        <h1>
            <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            Examples<small class="on-right"></small>
        </h1>

        <h2 id="__table__">Table</h2>
        <div class="example">
            <table class="table striped bordered hovered">
                <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Time CP</th>
                    <th class="text-left">Network</th>
                    <th class="text-left">Traffic</th>
                    <th class="text-left">Tiles update</th>
                </tr>
                </thead>

                <tbody>
                <tr class=""><td>Bing</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class=""><td>Bing</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class=""><td>Bing</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class=""><td>Bing</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class=""><td>Bing</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class="error"><td>Bing</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class="success"><td>Internet Explorer</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class="warning"><td>Chrome</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class="info"><td>News</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                <tr class="selected"><td>Music</td><td class="right">0:00:01</td><td class="right">0,1 Mb</td><td class="right">0 Mb</td><td class="right">0,1 Mb</td></tr>
                </tbody>
            </table>
        </div>

        <h2 id="__form__">Form</h2>
        <div class="example">
            <form>
                <fieldset>
                    <legend>Legend</legend>
                    <label>Label name</label>
                    <div class="input-control text" data-role="input-control">
                        <input type="text" placeholder="type text">
                        <button class="btn-clear" tabindex="-1"></button>
                    </div>
                    <label>Label name</label>
                    <div class="input-control password" data-role="input-control">
                        <input type="password" placeholder="type password" autofocus>
                        <button class="btn-reveal" tabindex="-1"></button>
                    </div>
                    <div class="input-control text" data-role="input-control">
                        <input type="text">
                        <button class="btn-search"></button>
                    </div>
                    <div class="input-control text warning-state" data-role="input-control">
                        <input type="text" value="warning state">
                    </div>
                    <div class="input-control file" data-role="input-control">
                        <input type="file">
                        <button class="btn-file"></button>
                    </div>

                    <div class="input-control text error-state" data-role="input-control">
                        <input type="text" value="error state">
                    </div>
                    <div class="input-control text info-state" data-role="input-control">
                        <input type="text" value="info state">
                    </div>
                    <div class="input-control text success-state" data-role="input-control">
                        <input type="text" value="info state">
                    </div>

                    <div class="input-control checkbox" data-role="input-control">
                        <label class="inline-block">
                            <input type="checkbox" />
                            <span class="check"></span>
                            Check me out
                        </label>
                        <label class="inline-block">
                            <input type="checkbox" checked />
                            <span class="check"></span>
                            Check me out
                        </label>
                        <label class="inline-block">
                            Check me out
                            <input type="checkbox" disabled/>
                            <span class="check"></span>
                        </label>
                        <label class="inline-block">
                            Check me out
                            <input type="checkbox" disabled checked/>
                            <span class="check"></span>
                        </label>
                        <label class="inline-block">
                            Intermediate
                            <input type="checkbox" data-show="intermediate"/>
                            <span class="check"></span>
                        </label>
                    </div>

                    <div>
                        <div class="clearfix">
                        <div class="input-control radio inline-block" data-role="input-control">
                            <label class="inline-block">
                                <input type="radio" name="r1" checked />
                                <span class="check"></span>
                                R1
                            </label>
                            <label class="inline-block">
                                <input type="radio" name="r1"  />
                                <span class="check"></span>
                                R1
                            </label>
                        </div>
                        <div class="input-control radio default-style inline-block" data-role="input-control">
                            <label class="inline-block">
                                <input type="radio" name="r2" checked />
                                <span class="check"></span>
                                R1
                            </label>
                            <label class="inline-block">
                                <input type="radio" name="r2" />
                                <span class="check"></span>
                                R2
                            </label>
                        </div>
                        </div>
                        <div class="input-control switch" data-role="input-control">
                            <label class="inline-block" style="margin-right: 20px">
                                Switch me
                                <input type="checkbox" checked/>
                                <span class="check"></span>
                            </label>
                            <label class="inline-block">
                                <input type="checkbox" disabled/>
                                <span class="check"></span>
                                Switch disabled
                            </label>
                        </div>
                    </div>

                    <input type="submit" value="Submit">
                    <input type="reset" value="Reset">
                    <input type="button" value="Button">

                    <div style="margin-top: 20px">
                    </div>

                </fieldset>
            </form>
        </div>

        <h2 id="__buttons__">Buttons</h2>
        <div class="example">
            <div>
                <button class="button large ">Large</button>
                <button class="button ">Default</button>
                <button class="button small ">Small</button>
                <button class="button mini ">Mini</button>
            </div>

            <div style="margin-top: 20px">
                <button class="button default">Default</button>
                <button class="button primary">Primary</button>
                <button class="button info">Info</button>
                <button class="button success">Success</button>
                <button class="button warning">Warning</button>
                <button class="button danger">Danger</button>
                <button class="button inverse">Inverse</button>
                <button class="button link">Link</button>
            </div>

            <div style="margin-top: 20px">
                <button class="button"><span class="icon-rocket on-left"></span>Rocket</button>
                <button class="button">Rocket<span class="icon-rocket on-right"></span></button>
            </div>

            <div style="margin-top: 20px">
                <button class="command-button ">
                    <i class="icon-share-2 on-left"></i>
                    Yes, share and connect
                    <small>Use this option for home or work</small>
                </button>
                <button class="command-button primary">
                    <i class="icon-windows on-left"></i>
                    Yes, share and connect
                    <small>Use this option for home or work</small>
                </button>
                <button class="command-button warning">
                    <i class="icon-share-3 on-right "></i>
                    Yes, share and connect
                    <small>Use this option for home or work</small>
                </button>
            </div>

            <div style="margin-top: 20px">
                <button class="image-button primary">
                    Download
                    <img src="images/download-32.png" class="bg-cobalt">
                </button>
                <button class="image-button danger">
                    GitHub
                    <i class="icon-github bg-red"></i>
                </button>
                <button class="image-button bg-darkGreen fg-white image-left">
                    Windows
                    <i class="icon-windows bg-green fg-white"></i>
                </button>
                <button class="image-button warning image-left">
                    Fork
                    <img src="images/fork-32.png" class="bg-cobalt">
                </button>
            </div>

            <div style="margin-top: 20px">
                <button class="shortcut primary">
                    <i class="icon-rocket"></i>
                    Rocket
                    <small class="bg-lightBlue fg-white">10</small>
                </button>
                <button class="shortcut danger">
                    <i class="icon-rocket"></i>
                    Rocket
                    <small class="bg-red fg-white">10</small>
                </button>
                <button class="shortcut link">
                    <i class="icon-rocket"></i>
                    Rocket
                    <small class="bg-cobalt fg-white">10</small>
                </button>
            </div>

            <div class="pagination" style="margin-top: 20px">
                <ul>
                    <li class="first"><a><i class="icon-first-2"></i></a></li>
                    <li class="prev"><a><i class="icon-previous"></i></a></li>
                    <li><a>1</a></li>
                    <li><a>2</a></li>
                    <li class="active"><a>3</a></li>
                    <li class="spaces"><a>...</a></li>
                    <li class="disabled"><a>4</a></li>
                    <li><a>500</a></li>
                    <li class="next"><a><i class="icon-next"></i></a></li>
                    <li class="last"><a><i class="icon-last-2"></i></a></li>
                </ul>
            </div>

            <nav class="breadcrumbs" style="margin-top: 20px">
                <ul>
                    <li><a href="#"><i class="icon-home"></i></a></li>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li class="active"><a href="#">Data</a></li>
                </ul>
            </nav>

        </div>


        <h2 id="__image__">Image container</h2>
        <div class="example">
            <div class="clearfix">
                <img src="../js/holder/holder.js/120x120" class="rounded">
                <img src="../js/holder/holder.js/120x120" class="cycle">
                <img src="../js/holder/holder.js/120x120" class="polaroid">
                <img src="../js/holder/holder.js/120x120" class="rounded polaroid">
                <img src="../js/holder/holder.js/120x120" class="cycle polaroid">
                <img src="../js/holder/holder.js/120x120" class="shadow">
            </div>

            <div style="margin-top: 20px">
                <div class="image-container">
                    <img src="images/2.jpg">
                    <div class="overlay">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="image-container shadow">
                    <img src="images/2.jpg">
                    <div class="overlay-fluid">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </div>
                </div>
                <div class="image-container selected">
                    <img src="images/2.jpg">
                </div>
            </div>
        </div>

        <h2 id="__tile__">Tiles</h2>
        <div class="example">
            <div class="tile bg-darkPink">
                <div class="tile-content icon">
                    <i class="icon-cart-2"></i>
                </div>
                <div class="tile-status">
                    <span class="name">Store</span>
                </div>
            </div>
            <div class="tile double bg-amber">
                <div class="tile-content icon">
                    <i class="icon-play-alt"></i>
                </div>
                <div class="brand bg-black">
                    <span class="label fg-white">Player</span>
                    <div class="badge bg-darkRed paused"></div>
                </div>
            </div>
            <div class="tile">
                <div class="tile-content image">
                    <img src="images/author.jpg">
                </div>
                <div class="brand">
                    <span class="label fg-white">Images</span>
                    <span class="badge bg-orange">12</span>
                </div>
            </div>
            <div class="tile double">
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="brand bg-dark opacity">
                    <span class="text">
                        This is a desert eagle. He is very hungry and angry bird.
                    </span>
                </div>
            </div>
            <div class="tile half bg-darkRed">
                <div class="tile-content icon">
                    <i class="icon-rocket"></i>
                </div>
            </div>
            <div class="tile half bg-darkOrange">
                <div class="tile-content icon">
                    <i class="icon-rocket"></i>
                </div>
            </div>
            <div class="tile bg-green">
                <div class="tile-content icon">
                    <img src="images/excel2013icon.png">
                </div>
            </div>
            <div class="tile double">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
            </div>
            <div class="tile double">
                <div class="tile-content image-set">
                    <img src="images/1.jpg">
                    <img src="images/2.jpg">
                    <img src="images/3.jpg">
                    <img src="images/4.jpg">
                    <img src="images/5.jpg">
                </div>
            </div>
            <div class="tile double live" data-role="live-tile">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/2.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/3.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/5.jpg">
                </div>

                <div class="tile-status bg-dark opacity">
                    <span class="label">effect: slideLeft</span>
                </div>
            </div>

            <div class="tile double live" data-role="live-tile" data-effect="slideRight">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/2.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/3.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/5.jpg">
                </div>

                <div class="tile-status bg-dark opacity">
                    <span class="label">effect: slideRight</span>
                </div>
            </div>

            <div class="tile double live" data-role="live-tile" data-effect="slideLeftRight">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/2.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/3.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/5.jpg">
                </div>

                <div class="tile-status bg-dark opacity">
                    <span class="label">effect: slideLeftRight</span>
                </div>
            </div>

            <div class="tile double live" data-role="live-tile" data-effect="slideUp">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/2.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/3.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/5.jpg">
                </div>

                <div class="tile-status bg-dark opacity">
                    <span class="label">effect: slideUp</span>
                </div>
            </div>

            <div class="tile double live" data-role="live-tile" data-effect="slideDown">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/2.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/3.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/5.jpg">
                </div>

                <div class="tile-status bg-dark opacity">
                    <span class="label">effect: slideDown</span>
                </div>
            </div>

            <div class="tile double live" data-role="live-tile" data-effect="slideUpDown">
                <div class="tile-content image">
                    <img src="images/1.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/2.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/3.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/4.jpg">
                </div>
                <div class="tile-content image">
                    <img src="images/5.jpg">
                </div>

                <div class="tile-status bg-dark opacity">
                    <span class="label">effect: slideUpDown</span>
                </div>
            </div>
        </div>

        <h2 id="__navbar__">Navigation bar</h2>
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

        <h2 id="__dropdown__">Dropdown menu</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span4">
                        <h4>Default</h4>
                        <ul class="dropdown-menu open keep-open" style="position: relative; width: 200px; z-index: 1">
                            <li class="menu-title">This is a title</li>
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li class="menu-title">This is another title</li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="disabled"><a href="#">Disabled link</a></li>
                            <li class="divider"></li>
                            <li class="checked"><a href="#">Checked link</a></li>
                        </ul>
                    </div>
                    <div class="span4">
                        <h4>Inverse</h4>
                        <ul class="dropdown-menu inverse open keep-open" style="position: relative; width: 200px; z-index: 1">
                            <li class="menu-title">This is a title</li>
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li class="menu-title">This is another title</li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="disabled"><a href="#">Disabled link</a></li>
                            <li class="divider"></li>
                            <li class="checked"><a href="#">Checked link</a></li>
                        </ul>
                    </div>
                    <div class="span4">
                        <h4>Dark</h4>
                        <ul class="dropdown-menu dark open keep-open" style="position: relative; width: 200px; z-index: 1">
                            <li class="menu-title">This is a title</li>
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li class="menu-title">This is another title</li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="disabled"><a href="#">Disabled link</a></li>
                            <li class="divider"></li>
                            <li class="checked"><a href="#">Checked link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__fluent__">Fluent menu</h2>
        <div class="example">
            <div class="fluent-menu" data-role="fluentmenu">
                <ul class="tabs-holder">
                    <li class="special"><a href="#">File</a></li>
                    <li class="active"><a href="#tab_home">Home</a></li>
                    <li><a href="#tab_mailings">Mailing</a></li>
                    <li><a href="#tab_folder">Folder</a></li>
                    <li><a href="#tab_view">View</a></li>
                </ul>

                <div class="tabs-content">
                    <div class="tab-panel" id="tab_home">
                        <div class="tab-panel-group">
                            <div class="tab-group-content">
                                <button class="fluent-big-button"><span class="icon-mail"></span>Create<br />message</button>
                                <div class="tab-content-segment">
                                    <button class="fluent-big-button dropdown-toggle">
                                        <span class="icon-pictures"></span>
                                        <span class="button-label">Create<br />element</span>
                                    </button>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="#">Message</a></li>
                                        <li><a href="#">Event</a></li>
                                        <li><a href="#">Meeting</a></li>
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content-segment">
                                    <button class="fluent-big-button">
                                        <span class="icon-cancel"></span>
                                        <span class="button-label">Delete</span>
                                    </button>
                                </div>
                            </div>
                            <div class="tab-group-caption">Clipboard</div>
                        </div>
                        <div class="tab-panel-group">
                            <div class="tab-group-content">
                                <div class="tab-content-segment">
                                    <button class="fluent-button"><span class="icon-reply on-left"></span>Replay</button>
                                    <button class="fluent-button"><span class="icon-reply-2 on-left"></span>Replay all</button>
                                    <button class="fluent-button"><span class="icon-cycle on-left"></span>Forward</button>
                                </div>
                                <div class="tab-content-segment">
                                    <button class="fluent-tool-button"><img src="images/Notebook-Save.png"></button>
                                    <button class="fluent-tool-button"><img src="images/Folder-Rename.png"></button>
                                    <button class="fluent-tool-button"><img src="images/Calendar-Next.png"></button>
                                </div>
                            </div>
                            <div class="tab-group-caption">Reply</div>
                        </div>
                        <div class="tab-panel-group">
                            <div class="tab-group-content">
                                <div class="input-control text">
                                    <input type="text">
                                    <button class="btn-search"></button>
                                </div>
                                <button class="fluent-button"><span class="icon-book on-left"></span>Address Book</button>
                                <div class="tab-content-segment">
                                    <button class="fluent-button dropdown-toggle">
                                        <span class="icon-filter on-left"></span>
                                        <span class="button-label">Mail Filters</span>
                                    </button>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="#">Unread messages</a></li>
                                        <li><a href="#">Has attachments</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Important</a></li>
                                        <li><a href="#">Broken</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-group-caption">Search</div>
                        </div>
                    </div>

                    <div class="tab-panel" id="tab_mailings">
                    </div>

                    <div class="tab-panel" id="tab_folder">
                    </div>

                    <div class="tab-panel" id="tab_view">
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__sidebar__">Sidebar</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span4">
                        <h3>Dark style (default)</h3>
                        <nav class="sidebar dark">
                            <ul>
                                <li class="title">Items Group 1</li>
                                <li class="active"><a href="#"><i class="icon-home"></i>Dashboard</a></li>
                                <li class="stick bg-red"><a href="#"><i class="icon-cog"></i>Layouts</a></li>
                                <li class="stick bg-yellow">
                                    <a class="dropdown-toggle" href="#"><i class="icon-tree-view"></i>Sub menu</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="">Subitem 1</a></li>
                                        <li><a href="">Subitem 2</a></li>
                                        <li><a href="">Subitem 3</a></li>
                                        <li class="divider"></li>
                                        <li><a href="">Subitem 4</a></li>
                                        <li class="disabled"><a href="">Subitem 4</a></li>
                                    </ul>
                                </li>
                                <li class="stick bg-green"><a href="#">Thread item</a></li>
                                <li class="disabled"><a href="#">Disabled item</a></li>

                                <li class="title">Items Group 2</li>
                                <li><a href="#">Other Item 1</a></li>
                                <li><a href="#">Other item 2</a></li>
                                <li><a href="#">Other item 3</a></li>
                                <li>
                                    <a class="dropdown-toggle" href="#">Sub menu 2</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="">Subitem 1</a></li>
                                        <li><a href="">Subitem 2</a></li>
                                        <li><a href="">Subitem 3</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="span1"></div>
                    <div class="span4">
                        <h3>Light style</h3>
                        <nav class="sidebar light">
                            <ul>
                                <li class="title">Items Group 1</li>
                                <li class="active"><a href="#"><i class="icon-home"></i>Dashboard</a></li>
                                <li class="stick bg-red"><a href="#"><i class="icon-cog"></i>Layouts</a></li>
                                <li class="stick bg-yellow">
                                    <a class="dropdown-toggle" href="#"><i class="icon-tree-view"></i>Sub menu</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="">Subitem 1</a></li>
                                        <li><a href="">Subitem 2</a></li>
                                        <li><a href="">Subitem 3</a></li>
                                        <li class="divider"></li>
                                        <li><a href="">Subitem 4</a></li>
                                        <li class="disabled"><a href="">Subitem 4</a></li>
                                    </ul>
                                </li>
                                <li class="stick bg-green"><a href="#">Thread item</a></li>
                                <li class="disabled"><a href="#">Disabled item</a></li>

                                <li class="title">Items Group 2</li>
                                <li><a href="#">Other Item 1</a></li>
                                <li><a href="#">Other item 2</a></li>
                                <li><a href="#">Other item 3</a></li>
                                <li>
                                    <a class="dropdown-toggle" href="#">Sub menu 2</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="">Subitem 1</a></li>
                                        <li><a href="">Subitem 2</a></li>
                                        <li><a href="">Subitem 3</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__tabs__">Tab control</h2>
        <div class="example">
            <div class="tab-control" data-role="tab-control">
                <ul class="tabs">
                    <li class="active"><a href="#_page_1">Tab 1</a></li>
                    <li><a href="#_page_2">Other Tab</a></li>
                    <li><a href="#_page_3"><i class="icon-rocket"></i></a></li>
                    <li class="place-right"><a href="#_page_5"><i class="icon-heart"></i></a></li>
                    <li class="place-right"><a href="#_page_4"><i class="icon-cog"></i></a></li>
                </ul>

                <div class="frames">
                    <div class="frame" id="_page_1">
                        <p>First Tab</p>
                    </div>
                    <div class="frame" id="_page_2">
                        <p>Second Tab</p>
                    </div>
                    <div class="frame" id="_page_3">
                        <p>Rocket Tab</p>
                    </div>
                    <div class="frame" id="_page_4">
                        <p>This tab placed right</p>
                    </div>
                    <div class="frame" id="_page_5">
                        <p>This tab also placed right</p>
                    </div>
                </div>

            </div>
        </div>

        <h2 id="__accordion__">Accordion</h2>
        <div class="example">
            <div class="accordion span3 place-left margin10" data-role="accordion" data-closeany="false">
                <div class="accordion-frame">
                    <a class="heading active" href="#" data-action="none" >Item #1</a>
                    <div class="content">
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</p>
                    </div>
                </div>
                <div class="accordion-frame">
                    <a class="heading active" href="#">Item #2</a>
                    <div class="content">
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>
                    </div>
                </div>
                <div class="accordion-frame">
                    <a class="heading" href="#">Item #3</a>
                    <div class="content">
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>
                        <button class="primary">Activate the account</button>
                    </div>
                </div>
            </div>

            <div class="accordion with-marker span3 place-left margin10" data-role="accordion" data-closeany="true">
                <div class="accordion-frame">
                    <a class="heading" href="#">Item #1</a>
                    <div class="content">
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</p>
                    </div>
                </div>
                <div class="accordion-frame">
                    <a class="heading" href="#">Item #2</a>
                    <div class="content">
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>
                    </div>
                </div>
                <div class="accordion-frame">
                    <a class="heading" href="#">Item #3</a>
                    <div class="content">
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>
                        <button class="primary">Activate the account</button>
                    </div>
                </div>
            </div>

            <div class="accordion with-marker span3 place-left margin10" data-role="accordion" data-closeany="false">
                <div class="accordion-frame">
                    <a class="heading bg-lightBlue fg-white" href="#">Item #1</a>
                    <div class="content">
                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</p>
                    </div>
                </div>
                <div class="accordion-frame">
                    <a class="heading text-right ribbed-green fg-white" href="#">Item #2</a>
                    <div class="content">
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>
                    </div>
                </div>
                <div class="accordion-frame">
                    <a class="heading ribbed-red fg-white" href="#">Item #3</a>
                    <div class="content">
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut.</p>
                        <button class="primary">Activate the account</button>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__rating__">Rating</h2>
        <div class="example">
            <div class="rating large" data-static="false" data-score="3" data-stars="5" data-role="rating" data-show-score="true" data-score-hint="Rating: "></div>
            <div id="rating_1" class="fg-green" data-role="rating" data-show-score="true"></div>
            <div class="rating small fg-red" data-static="false" data-score="3" data-stars="5" data-role="rating" data-show-score="true" data-score-hint="Value: "></div>
        </div>

        <h2 id="__progress__">Progress bar</h2>
        <div class="example">
            <div class="progress-bar" data-role="progress-bar" data-value="10"></div>
            <div class="progress-bar" data-role="progress-bar" data-value="20" data-color="bg-green"></div>
            <div class="progress-bar" data-role="progress-bar" data-value="50" data-color="bg-red"></div>
            <div class="progress-bar" data-role="progress-bar" data-value="75" data-color="bg-pink"></div>
            <div class="progress-bar" data-role="progress-bar" data-value="100" data-color="#ccc"></div>
        </div>

        <h2 id="__scroll__">Scroll bar</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span4">
                        <h4>Vertical scroll</h4>
                        <div id="scrollbox1" data-role="scrollbox1" data-scroll="vertical">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                    </div>
                    <div class="span4">
                        <h4>Horizontal scroll</h4>
                        <div id="scrollbox2" data-role="scrollbox1" data-scroll="horizontal" style="width: 1000px">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                    </div>
                    <div class="span4">
                        <h4>Both scrolls</h4>
                        <div id="scrollbox3" data-role="scrollbox1" data-scroll="both" style="width: 500px">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(function(){
                    $("#scrollbox1").scrollbar({
                        height: 355,
                        axis: 'y'
                    });
                    $("#scrollbox2").scrollbar({
                        axis: 'x',
                        height: 355
                    });
                    $("#scrollbox3").scrollbar({
                        height: 355
                    });
                });
            </script>
        </div>

        <h2 id="__slider__">Slider</h2>
        <div class="example">
            <div>
                <div class="slider" id="s1" data-role="slider" data-position="25" data-accuracy="0"></div>
                <div class="slider" data-role="slider" data-position="55" data-accuracy="0" data-colors="blue, red, yellow, green"></div>
            </div>
            <div style="margin-top: 20px" class="clearfix">
                <div class="slider vertical place-left" data-role="slider" data-position="20" data-accuracy="0"></div>
                <div class="slider vertical place-left" data-role="slider" data-position="0" data-accuracy="20"></div>
                <div class="slider vertical place-left" data-role="slider" data-position="40" data-accuracy="0" data-color="green"></div>
                <div class="slider vertical place-left" data-role="slider" data-position="70" data-accuracy="0" data-color="#f00"></div>
                <div class="slider vertical place-left" data-role="slider" data-position="70" data-accuracy="0" data-color="black" data-complete-color="blue" data-marker-color="yellow"></div>
            </div>
        </div>

        <h2 id="__carousel__">Carousel</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <div class="carousel" id="carousel1">
                            <div class="slide">
                                <img src="images/1.jpg" class="cover1" />
                            </div>

                            <div class="slide">
                                <img src="images/2.jpg" class="cover1" />
                            </div>

                            <div class="slide">
                                <img src="images/3.jpg" class="cover1"/>
                            </div>

                            <a class="controls left"><i class="icon-arrow-left-3"></i></a>
                            <a class="controls right"><i class="icon-arrow-right-3"></i></a>
                        </div>
                        <script>
                            $(function(){
                                $("#carousel1").carousel({
                                    height: 200
                                });
                            })
                        </script>
                    </div>
                    <div class="span6">
                        <div class="carousel" id="carousel2">
                            <div class="slide">
                                <img src="images/1.jpg" class="cover1" />
                            </div>

                            <div class="slide">
                                <img src="images/2.jpg" class="cover1" />
                            </div>

                            <div class="slide">
                                <img src="images/3.jpg" class="cover1"/>
                            </div>
                        </div>
                        <script>
                            $(function(){
                                $("#carousel2").carousel({
                                    height: 200,
                                    effect: 'fade',
                                    markers: {
                                        show: true,
                                        type: 'square',
                                        position: 'bottom-right'
                                    }
                                });
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__tree__">Tree view</h2>
        <div class="example">
            <ul class="treeview" data-role="treeview">
                <li class="node">

                    <a href="#"><span class="node-toggle"></span>sergey@pimenov.com.ua</a>
                    <ul>
                        <li><a href="#">Inbox</a></li>
                        <li><a href="#">Outbox</a></li>
                        <li><a href="#">Drafts</a></li>
                        <li><a href="#">Rss-channels</a></li>
                        <li><a href="#">Trash <span class="value">[5]</span></a></li>
                        <li class="node">

                            <a href="#"><span class="node-toggle"></span>subnode</a>
                            <ul>
                                <li><a href="#">Inbox</a></li>
                                <li><a href="#">Outbox</a></li>
                                <li><a href="#">Drafts</a></li>
                                <li><a href="#">Rss-channels</a></li>
                                <li><a href="#">Trash</a></li>
                                <li class="node">

                                    <a href="#"><span class="node-toggle"></span>subnode 2</a>
                                    <ul>
                                        <li><a href="#">Inbox</a></li>
                                        <li><a href="#">Outbox</a></li>
                                        <li><a href="#">Drafts</a></li>
                                        <li><a href="#">Rss-channels</a></li>
                                        <li><a href="#">Trash</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="node">

                    <a href="#"><span class="node-toggle"></span>support@metroui.net</a>
                    <ul>
                        <li><a href="#">Inbox</a></li>
                        <li><a href="#">Outbox</a></li>
                        <li><a href="#">Drafts</a></li>
                        <li><a href="#">Rss-channels</a></li>
                        <li><a href="#">Trash</a></li>
                    </ul>
                </li>
                <li class="node collapsed">

                    <a href="#"><span class="node-toggle"></span>info@metroui.net</a>
                    <ul>
                        <li><a href="#">Inbox</a></li>
                        <li><a href="#">Outbox</a></li>
                        <li><a href="#">Drafts</a></li>
                        <li><a href="#">Rss-channels</a></li>
                        <li><a href="#">Trash</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <h2 id="__lists__">List view</h2>
        <div class="example">
            <div class="listview">
                <a href="#" class="list">
                    <div class="list-content">
                        <img src="images/excel2013icon.png" class="icon">
                        <div class="data">
                            <span class="list-title">Excel 2013</span>
                            <div class="rating small no-margin" data-role="rating" data-stars="5"></div>
                            <span class="list-remark">Price: $1</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="list bg-lightBlue fg-white">
                    <div class="list-content">
                        <img src="images/word2013icon.png" class="icon">
                        <div class="data">
                            <span class="list-title">Word 2013</span>
                            <div class="rating small no-margin fg-yellow" data-score="4" data-role="rating" data-stars="5"></div>
                            <span class="list-remark">Price: $1</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="list selected">
                    <div class="list-content">
                        <img src="images/onenote2013icon.png" class="icon">
                        <div class="data">
                            <span class="list-title">Word 2013</span>
                            <div class="progress-bar small" data-role="progress-bar" data-value="75"></div>
                            <span class="list-remark">Download...75%</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="listview-outlook" data-role="listview" style="margin-top: 20px">
                <div class="list-group ">
                    <a href="" class="group-title">Today</a>
                    <div class="group-content">
                        <a class="list marked" href="#">
                            <div class="list-content">
                                <span class="list-title">subscribe@metroui.net</span>
                                <span class="list-subtitle">MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                        <a class="list" href="#">
                            <div class="list-content">
                                <span class="list-title">subscribe@metroui.net</span>
                                <span class="list-subtitle">MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                        <a class="list active" href="#">
                            <div class="list-content">
                                <span class="list-title">subscribe@metroui.net</span>
                                <span class="list-subtitle">MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                        <a class="list" href="#">
                            <div class="list-content">
                                <span class="list-title">subscribe@metroui.net</span>
                                <span class="list-subtitle">MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="list-group collapsed">
                    <a href="" class="group-title">Yesterday</a>
                    <div class="group-content">
                        <a class="list" href="#">
                            <div class="list-content">
                                <span class="list-title"><span class="place-right icon-flag-2 fg-red smaller"></span>subscribe@metroui.net</span>
                                <span class="list-subtitle"><span class="place-right">1:51</span>MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                        <a class="list" href="#">
                            <div class="list-content">
                                <span class="list-title"><span class="place-right icon-flag-2 fg-green smaller"></span>subscribe@metroui.net</span>
                                <span class="list-subtitle"><span class="place-right">1:51</span>MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                        <a class="list" href="#">
                            <div class="list-content">
                                <span class="list-title">subscribe@metroui.net</span>
                                <span class="list-subtitle"><span class="place-right">1:51</span>MetroUI: News on 26/10/2013</span>
                                <span class="list-remark">Hello friend! Newest for Metro UI CSS</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__hint__">Hint</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span3">
                        <div class="text-center padding10 border" data-hint="Title|This is a hint for element. Hint can be written as html.">Hint on bottom</div>
                    </div>
                    <div class="span3">
                        <div class="text-center padding10 border" data-hint-position="top" data-hint="Title|This is a hint for element. Hint can be written as html.">Hint on top</div>
                    </div>
                    <div class="span3">
                        <div class="text-center padding10 border" data-hint-position="right" data-hint="Title|This is a hint for element. Hint can be written as html.">Hint on right</div>
                    </div>
                    <div class="span3">
                        <div class="text-center padding10 border" data-hint-position="left" data-hint="Title|This is a hint for element. Hint can be written as html.">Hint on left</div>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__balloon__">Balloon</h2>
        <div class="example">
            <div class="balloon left">
                <div class="padding20">
                    Balloon is represent to create information or dialog UI. You can put inside any of elements.
                </div>
            </div>

            <div class="balloon right">
                <div class="tab-control padding20" data-role="tab-control">
                    <p class="place-right tertiary-text">Comments are parsed with <a href="https://help.github.com/articles/github-flavored-markdown">GitHub Flavored Markdown</a></p>
                    <ul class="tabs">
                        <li class="active"><a href="#write">Write</a></li>
                        <li><a href="#preview">Preview</a></li>
                    </ul>

                    <div class="frames">
                        <div id="write" class="frame">
                            <textarea data-transform="input-control" placeholder="leave a comment"></textarea>
                        </div>
                        <div id="preview" class="frame">
                            This is preview :)
                        </div>
                    </div>
                </div>
            </div>

            <div class="balloon bottom">
                <div class="padding20">
                    Balloon is represent to create information or dialog UI. You can put inside any of elements.
                </div>
            </div>

            <div class="balloon top">
                <div class="padding20">
                    Balloon is represent to create information or dialog UI. You can put inside any of elements.
                </div>
            </div>
        </div>

        <h2 id="__notice__">Notice</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span3">
                        <div class="notice">
                            <div class="fg-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="notice marker-on-top bg-amber">
                            <div class="fg-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="notice marker-on-right bg-pink">
                            <div class="fg-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="notice marker-on-bottom bg-darkRed fg-white">
                            <div class="">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__calendar__">Calendar &amp; Datepicker</h2>
        <div class="example">
            <div class="clearfix">
                <div class="margin5 place-left"><div class="calendar small" data-role="calendar" ></div></div>
                <div class="margin5 place-left"><div class="calendar small" data-role="calendar" data-start-mode="month"></div></div>
                <div class="margin5 place-left"><div class="calendar small" data-role="calendar" data-start-mode="year"></div></div>
            </div>

            <div>
                <div class="grid fluid">
                    <div class="row">
                        <div class="span3">
                            <div class="input-control text" data-role="datepicker" data-week-start="1">
                                <input type="text">
                                <button class="btn-date"></button>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="input-control text" data-role="datepicker" data-date="2013-11-13" data-effect="slide" data-other-days="1">
                                <input type="text">
                                <button class="btn-date"></button>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="input-control text" data-role="datepicker" data-date="2013-11-14" data-format="dddd, mmmm d, yyyy" data-effect="fade">
                                <input type="text">
                                <button class="btn-date"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__times__">Countdown &amp; Times</h2>
        <div class="example">
            <div class="countdown inverse" data-role="countdown"></div>
            <div class="times inverse" data-role="times" data-blink="false" style="font-size: 40px"></div>
        </div>

        <h2 id="__window__">Window</h2>
        <div class="example">
            <div class="clearfix">
                <div class="grid fluid">
                    <div class="row no-margin">
                        <div class="span4">
                            <h3>Active window</h3>
                            <div class="window">
                                <div class="caption">
                                    <span class="icon icon-windows"></span>
                                    <div class="title">Window caption</div>
                                    <button class="btn-min"></button>
                                    <button class="btn-max"></button>
                                    <button class="btn-close"></button>
                                </div>
                                <div class="content">
                                    Window content
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <h3>Window with shadow</h3>
                            <div class="window shadow">
                                <div class="caption">
                                    <span class="icon icon-windows"></span>
                                    <div class="title">Window caption</div>
                                    <button class="btn-min"></button>
                                    <button class="btn-max"></button>
                                    <button class="btn-close"></button>
                                </div>
                                <div class="content">
                                    Window content
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <h3>Inactive window</h3>
                            <div class="window inactive">
                                <div class="caption">
                                    <span class="icon icon-windows"></span>
                                    <div class="title">Window caption</div>
                                    <button class="btn-min"></button>
                                    <button class="btn-max"></button>
                                    <button class="btn-close"></button>
                                </div>
                                <div class="content">
                                    Window content
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix" style="margin-top: 20px">
                <div class="grid fluid">
                    <div class="row no-margin">
                        <div class="span4">
                            <h3>Active window</h3>
                            <div class="window flat">
                                <div class="caption">
                                    <span class="icon icon-windows"></span>
                                    <div class="title">Window caption</div>
                                    <button class="btn-min"></button>
                                    <button class="btn-max"></button>
                                    <button class="btn-close"></button>
                                </div>
                                <div class="content">
                                    Window content
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <h3>Window with shadow</h3>
                            <div class="window flat shadow">
                                <div class="caption">
                                    <span class="icon icon-windows"></span>
                                    <div class="title">Window caption</div>
                                    <button class="btn-min"></button>
                                    <button class="btn-max"></button>
                                    <button class="btn-close"></button>
                                </div>
                                <div class="content">
                                    Window content
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <h3>Inactive window</h3>
                            <div class="window flat inactive">
                                <div class="caption">
                                    <span class="icon icon-windows"></span>
                                    <div class="title">Window caption</div>
                                    <button class="btn-min"></button>
                                    <button class="btn-max"></button>
                                    <button class="btn-close"></button>
                                </div>
                                <div class="content">
                                    Window content
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__streamer__">Streamer</h2>
        <div class="example">
            <div class="streamer" data-role="streamer" data-scroll-bar="true" data-slide-to-group="3" data-slide-speed="500">
                <div class="streams">
                    <div class="streams-title">
                        <div class="toolbar">
                            <button class="button small js-show-all-streams" title="Show all streams" data-role=""><span class="icon-eye"></span></button>
                            <button class="button small js-schedule-mode" title="On|Off schedule mode" data-role=""><span class="icon-history"></span></button>
                            <button class="button small js-go-previous-time" title="Go to previous time interval" data-role=""><span class="icon-previous"></span></button>
                            <button class="button small js-go-next-time" title="Go to next time interval" data-role=""><span class="icon-next"></span></button>
                        </div>
                    </div>
                    <div class="stream bg-teal">
                        <div class="stream-title">INTERNET<br />BUSINESS</div>
                        <div class="stream-number">room 1</div>
                    </div>
                    <div class="stream bg-orange">
                        <div class="stream-title">ADVERTISING<br />ANALYST<br />SEO</div>
                        <div class="stream-number">room 2</div>
                    </div>
                    <div class="stream bg-lightBlue">
                        <div class="stream-title">STARTUPS<br />E-COMMERCE</div>
                        <div class="stream-number">room 3</div>
                    </div>
                    <div class="stream bg-darkGreen">
                        <div class="stream-title">MOBILE<br />GAMES<br />USABILITY</div>
                        <div class="stream-number">room 4</div>
                    </div>
                    <div class="stream bg-pink">
                        <div class="stream-title">INTERNET<br />TECHNOLOGY</div>
                        <div class="stream-number">room 5</div>
                    </div>
                    <div class="stream bg-violet">
                        <div class="stream-title">MASTERS</div>
                        <div class="stream-number">room 6</div>
                    </div>
                </div>

                <div class="events">
                    <div class="events-area">
                        <div class="events-grid">
                            <div class="event-group double">
                                <div class="event-super padding20">
                                    <div>9:00 - 9:40</div>
                                    <h2 class="no-margin">Registration</h2>
                                </div>
                            </div>
                            <div class="event-group double" id="qwerty">
                                <div class="event-super padding20">
                                    <div>9:40 - 10:20</div>
                                    <h2 class="no-margin">Keynote speech</h2>

                                    <br />
                                    <img src="images/org-01.png">
                                    <h4 class="no-margin">Aleksandr Olshanskiy</h4>
                                    <p>Imena.UA, MiroHost</p>

                                </div>
                            </div>

                            <div class="event-group">
                                <div class="event-stream" >
                                    <div class="event" data-role="live">
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/live1.jpg">
                                                <div class="time">10:20</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Katerina Kostereva</div>
                                                <div class="subtitle">Terrasoft</div>
                                                <div class="remark">Create and develop a business without external investment</div>
                                            </div>
                                        </div>
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/live2.jpg">
                                                <div class="time">10:30</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Vlad Voskresensky</div>
                                                <div class="subtitle">InvisibleCRM</div>
                                                <div class="remark">Team Building in your startup: what to do and what not</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event double">
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/x.jpg">
                                                <div class="time">10:40</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Round table</div>
                                                <div class="remark">Trends in mobile platforms</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event double"></div>
                                    <div class="event double"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event double"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                    <div class="event"></div>
                                </div>

                                <div class="event-stream" >
                                    <div class="event triple">
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/x.jpg">
                                                <div class="time">10:40</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Round table</div>
                                                <div class="remark">Trends in mobile platforms</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event">
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/me.jpg">
                                                <div class="time">10:20</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Sergey Pimenov</div>
                                                <div class="subtitle">Metro UI CSS</div>
                                                <div class="remark">Create a site with interface similar to Windows 8</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="event-stream" >
                                    <div class="event" data-role="live" data-effect="slideUp" data-period="3000">
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/me.jpg">
                                                <div class="time">10:20</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Sergey Pimenov</div>
                                                <div class="subtitle">Metro UI CSS</div>
                                                <div class="remark">Create a site with interface similar to Windows 8</div>
                                            </div>
                                        </div>
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/x.jpg">
                                                <div class="time">10:30</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Round table</div>
                                                <div class="subtitle">Metro UI CSS</div>
                                                <div class="remark">Discussion</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="event double">
                                        <div class="event-content">
                                            <div class="event-content-logo">
                                                <img class="icon" src="images/x.jpg">
                                                <div class="time">10:40</div>
                                            </div>
                                            <div class="event-content-data">
                                                <div class="title">Round table</div>
                                                <div class="remark">Trends in mobile platforms</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="event-group double">
                                <div class="event-super padding20">
                                    <div>18:20</div>
                                    <h2 class="no-margin">Final ceremony</h2>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 id="__stepper__">Stepper</h2>
        <div class="example">
            <h3>Default</h3>
            <div class="stepper" data-role="stepper" data-steps="5" data-start="3"></div>
            <h3>Rounded</h3>
            <div class="stepper rounded" data-role="stepper" data-steps="5" data-start="3"></div>
            <h3>Diamond</h3>
            <div class="stepper diamond" data-role="stepper" data-steps="5" data-start="3"></div>

            <h3>Events</h3>
            <div class="stepper" data-role="stepper" data-steps="5" id="demo_stepper_methods"></div>
            <div class="actions">
                <button class="button" onclick="$('#demo_stepper_methods').stepper('next')">Next</button>
                <button class="button" onclick="$('#demo_stepper_methods').stepper('prior')">Prior</button>
                <button class="button" onclick="$('#demo_stepper_methods').stepper('first')">First</button>
                <button class="button" onclick="$('#demo_stepper_methods').stepper('last')">Last</button>
            </div>
        </div>

        <h2 id="__panel__">Panels</h2>
        <div class="example">
            <div class="grid fluid">
                <div class="row">
                    <div class="span4">
                        <h3>Default</h3>
                        <div class="panel">
                            <div class="panel-header">
                                Lorem Ipsum
                            </div>
                            <div class="panel-content">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            </div>
                        </div>
                    </div>

                    <div class="span4">
                        <h3>Custom color</h3>
                        <div class="panel">
                            <div class="panel-header bg-lightBlue fg-white">
                                Lorem Ipsum
                            </div>
                            <div class="panel-content">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            </div>
                        </div>
                    </div>

                    <div class="span4">
                        <h3>Collapsible</h3>
                        <div class="panel" data-role="panel">
                            <div class="panel-header bg-darkRed fg-white">
                                Lorem Ipsum
                            </div>
                            <div class="panel-content">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- End of container -->

    <script src="../js/hitua.js"></script>

</body>
</html>