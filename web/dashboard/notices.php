<!DOCTYPE html>
<html>
<?php include_once 'header.php' ?>
<body class="metro">
    <header class="bg-dark" data-load="header.html"></header>
    <div class="container">
                <h1>
                    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Notices<small class="on-right">component</small>
                </h1>

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
<pre class="prettyprint linenums">
&lt;div class="notice"&gt;
    ... content ...
&lt;/div&gt;

&lt;div class="notice marker-on-top"&gt;
    ... content ...
&lt;/div&gt;

&lt;div class="notice marker-on-right"&gt;
    ... content ...
&lt;/div&gt;

&lt;div class="notice marker-on-bottom"&gt;
    ... content ...
&lt;/div&gt;
</pre>
                <p>
                    To set background color you can use predefined colors <code>bg-*</code>. To set color you can use predefined colors <code>fg-*</code>.
                </p>
<pre class="prettyprint linenums">
&lt;div class="notice bg-amber fg-white"&gt;
    ... content ...
&lt;/div&gt;
</pre>

    </div>

    <script src="js/hitua.js"></script>

</body>
</html>