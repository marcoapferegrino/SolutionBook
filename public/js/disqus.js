/* * * CONFIGURATION VARIABLES * * */
var disqus_shortname = 'solutionbook24nya';
var disqus_title= $("#title1").val();
var disqus_identifier = $("#idProblem").val()+$("#title1").val();
var disqus_url = "https://solution.book/showProblem/"+$("#idProblem").val();

/*
 var disqus_title= <? php echo $dataProblem->title; ?>;
 var disqus_identifier = '<? php echo $dataProblem->id; ?>';
 var disqus_url = "https://solution.book/showProblem/"+'<? php echo $dataProblem->id; ?>';

 */


(function() {
    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();



/* * * DON'T EDIT BELOW THIS LINE * * */
(function () {
    var s = document.createElement('script'); s.async = true;
    s.type = 'text/javascript';
    s.src = '//' + disqus_shortname + '.disqus.com/count.js';
    (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());