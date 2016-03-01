<!DOCTYPE html>
<html>
<?php include_once "header.php"; ?>
<body class="metro">
    <header class="bg-dark" data-load="header.html"></header>
    <div class="container">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Tile<small class="on-right">component</small>
                </h1>

                <h2>General info</h2>
                <p class="description">
                    Tiles are the representation of your app or sub module. The content shown on your tile can, and ideally should, change regularly, especially if your tile can communicate new, real-time information to your user. Tiles can show a combination of text and images, and a badge to show status. Tile is a block object and can be placed in any container.
                </p>

                <p class="padding20 border text-center">
                    Start with this <a href="start-screen.html">demonstration</a>
                </p>

                <div class="example">
                    <div class="tiles">
                        <div class="tile half"></div>
                        <div class="tile"></div>
                        <div class="tile double"></div>
                        <div class="tile selected"></div>
                    </div>
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile"&gt;&lt;/div&gt;
&lt;div class="tile double"&gt;&lt;/div&gt;
&lt;div class="tile selected"&gt;&lt;/div&gt;
</pre>


                <h3>Tile sizes</h3>
                <p class="description">
                    Metro UI CSS is supported any tiles sizes: <strong>half, default, double, triple, quadro</strong>.
                    You can set sizing of tile with build-in tile subclasses: <code>half</code>, <code>double</code>, <code>triple</code> and <code>quadro</code>.
                </p>
                <div class="example">
                    <div class="tile half block"><img src="../js/metroui/holder/holder.js/55x55"></div>
                    <div class="tile block"><img src="../js/holder/holder.js/120x120"></div>
                    <div class="tile double block"><img src="../js/holder/holder.js/250x120"></div>
                    <div class="tile triple block"><img src="../js/holder/holder.js/380x120"></div>
                    <div class="tile quadro block"><img src="../js/holder/holder.js/530x120"></div>
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile half"&gt;&lt;/div&gt;
&lt;div class="tile"&gt;&lt;/div&gt;
&lt;div class="tile double"&gt;&lt;/div&gt;
&lt;div class="tile triple"&gt;&lt;/div&gt;
&lt;div class="tile quadro"&gt;&lt;/div&gt;
</pre>
                <p>To change vertical size use next sub classes: <code>double-vertical</code>, <code>triple-vertical</code> and <code>quadro-vertical</code>.</p>
<pre class="prettyprint linenums">
&lt;div class="tile double-vertical"&gt;&lt;/div&gt;
&lt;div class="tile triple-vertical"&gt;&lt;/div&gt;
&lt;div class="tile quadro-vertical"&gt;&lt;/div&gt;
</pre>

                <h3>Tile Badges</h3>
                <p class="description">
                    A badge can display either a number from 1-99 or a status glyph. badge is positioned in tile status container on the bottom right corner.
                    Metro UI CSS support main Windows 8 badges: <code>activity</code>, <code>alert</code>, <code>available</code>, <code>away</code>, <code>busy</code>,
                    <code>newMessage</code>, <code>paused</code>, <code>playing</code>, <code>unavailable</code>, <code>error</code> and <code>attention</code> as built-in.
                    The badge background color can be changed with built-in classes <code>bg-*</code>.
                </p>
                <div class="example">
                    <div class="tile bg-cyan">
                        <div class="tile-status">
                            <div class="badge bg-red">99</div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="tile-status">
                            <div class="badge activity"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge alert"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge available"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge away"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge busy"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge newMessage"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge paused"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge playing"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge unavailable"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge error"></div>
                        </div>
                    </div>
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge attention"></div>
                        </div>
                    </div>
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile bg-cyan"&gt;
    &lt;div class="brand"&gt;
        &lt;div class="badge"&gt;99&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile bg-cyan"&gt;
    &lt;div class="brand"&gt;
        &lt;div class="badge activity"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</pre>

                <p class="description">
                    You can create custom <code>bage</code> with <code>&lt;i class="icon-*"&gt;</code>
                </p>
                <div class="example">
                    <div class="tile bg-cyan">
                        <div class="brand">
                            <div class="badge"><i class="icon-rocket"></i></div>
                        </div>
                    </div>
                    <div class="tile bg-darkRed">
                        <div class="brand">
                            <div class="badge bg-red"><i class="icon-broadcast"></i></div>
                        </div>
                    </div>
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile bg-cyan"&gt;
    &lt;div class="brand"&gt;
        &lt;div class="badge"&gt;&lt;i class="icon-rocket"&gt;&lt;/i&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class="tile bg-darkRed"&gt;
    &lt;div class="brand"&gt;
        &lt;div class="badge bg-red"&gt;&lt;i class="icon-broadcast"&gt;&lt;/i&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</pre>

                <h3>Tile status (brand)</h3>
                <p class="description">
                    Status provides additional information for tile. This may be: name, label, text or badge. Tile status container can be created with <code>tile-status</code> or <code>brand</code> classes.
                </p>
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
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile bg-darkPink"&gt;
    &lt;div class="tile-content icon"&gt;
        &lt;i class="icon-cart-2"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;div class="tile-status"&gt;
        &lt;span class="name"&gt;Store&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile double bg-amber"&gt;
    &lt;div class="tile-content icon"&gt;
        &lt;i class="icon-play-alt"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;div class="brand bg-black"&gt;
        &lt;span class="label fg-white"&gt;Player&lt;/span&gt;
        &lt;div class="badge bg-darkRed paused"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile"&gt;
    &lt;div class="tile-content image"&gt;
        &lt;img src="images/author.jpg"&gt;
    &lt;/div&gt;
    &lt;div class="brand"&gt;
        &lt;span class="label fg-white"&gt;Images&lt;/span&gt;
        &lt;span class="badge bg-orange"&gt;12&lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile double"&gt;
    &lt;div class="tile-content image"&gt;
        &lt;img src="images/4.jpg"&gt;
    &lt;/div&gt;
    &lt;div class="brand bg-dark opacity"&gt;
        &lt;span class="text"&gt;
            This is a desert eagle. He is very hungry and angry bird.
        &lt;/span&gt;
    &lt;/div&gt;
&lt;/div&gt;
</pre>

                <h3>Tile content</h3>
                <p class="description">
                    Tile content can be placed in sub container with class <code>.tile-content</code>.
                    Tiles content can be organized with built-in subclasses: <code>icon</code>, <code>image</code>, <code>image-set</code>.
                </p>
                <div class="example">
                    <div class="tile half bg-darkRed">
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
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile bg-cyan"&gt;
    &lt;div class="tile-content icon"&gt;
        &lt;i class="icon-rocket"&gt;&lt;/i&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile bg-green"&gt;
    &lt;div class="tile-content icon"&gt;
        &lt;img src="images/excel2013icon.png"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile double"&gt;
    &lt;div class="tile-content image"&gt;
        &lt;img src="images/1.jpg"&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class="tile double"&gt;
    &lt;div class="tile-content image-set"&gt;
        &lt;img src="images/1.jpg"&gt;
        &lt;img src="images/2.jpg"&gt;
        &lt;img src="images/3.jpg"&gt;
        &lt;img src="images/4.jpg"&gt;
        &lt;img src="images/5.jpg"&gt;
    &lt;/div&gt;
&lt;/div&gt;
</pre>

                <h3>Live Tile</h3>
                <p class="description">
                    You can set effect with <code>data-effect</code> attribute.
                </p>
                <div class="example">
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
<pre class="prettyprint linenums">
&lt;div class="tile live" data-role="live-tile" data-effect="..."&gt;
    &lt;div class="tile-content"&gt;...&lt;/div&gt;
    &lt;div class="tile-content"&gt;...&lt;/div&gt;
&lt;/div&gt;
</pre>
                <p class="description">
                    To change easing effect you can use any jquery easing plugins (example: <a href="https://github.com/gdsmith/jquery.easing">jQuery Easing Plugin</a>)
                    or create you own function and set attribute <code>data-easing</code> to <code>tile</code> with the name of <code>easing</code>.
                </p>
                <div class="example">
                    <div class="tile double live" data-role="live-tile" data-easing="easeInBounce">
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
                            <span class="label">ease: easeInBounce</span>
                        </div>
                    </div>

                    <div class="tile double live" data-role="live-tile" data-effect="slideRight" data-easing="easeInBack">
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
                            <span class="label">ease: easeInBack</span>
                        </div>
                    </div>

                    <div class="tile double live" data-role="live-tile" data-effect="slideLeftRight" data-easing="easeInElastic">
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
                            <span class="label">ease: easeInElastic</span>
                        </div>
                    </div>

                    <div class="tile double live" data-role="live-tile" data-effect="slideUp" data-easing="easeInCirc">
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
                            <span class="label">ease: easeInCirc</span>
                        </div>
                    </div>

                    <div class="tile double live" data-role="live-tile" data-effect="slideDown" data-easing="easeInExpo">
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
                            <span class="label">ease: easeInExpo</span>
                        </div>
                    </div>

                    <div class="tile double live" data-role="live-tile" data-effect="slideUpDown" data-easing="easeInSine">
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
                            <span class="label">ease: easeInSine</span>
                        </div>
                    </div>
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile live" data-role="live-tile" data-effect="..." data-easing="..."&gt;
    &lt;div class="tile-content"&gt;...&lt;/div&gt;
    &lt;div class="tile-content"&gt;...&lt;/div&gt;
&lt;/div&gt;
</pre>

                <h3>Tile click transform</h3>
                <p class="description">
                    You can set effect with <code>data-click="transform"</code> attribute.
                </p>

                <div class="example">
                    <div class="tile half bg-darkRed ol-transparent" data-click="transform">
                        <div class="tile-content icon">
                            <i class="icon-rocket"></i>
                        </div>
                    </div>
                    <div class="tile bg-green ol-transparent" data-click="transform">
                        <div class="tile-content icon">
                            <img src="images/excel2013icon.png">
                        </div>
                    </div>
                    <a class="tile double ol-transparent" data-click="transform">
                        <div class="tile-content image">
                            <img src="images/1.jpg">
                        </div>
                    </a>
                </div>
<pre class="prettyprint linenums">
&lt;div class="tile" data-click="transform"&gt;
    ...
&lt;/div&gt;
</pre>

    </div>

    <script src="js/hitua.js"></script>

</body>
</html>