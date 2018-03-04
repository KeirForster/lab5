<h1>Task # {id}</h1>
<form role="form" action="/mtce/submit" method="post">
    <div class="form-group">
        {ftask}
    </div>
    <div class="form-group">
        {fpriority}
    </div>
    <div class="form-group">
        {fsize}
    </div>
    <div class="form-group">
        {fgroup}
    </div>
    <div class="form-group">
        {fstatus}
    </div>
    <div class="form-group">
        {zsubmit}
    </div>
</form>
<a href="/mtce/cancel"><input type="button" value="Cancel the current edit"/></a>
<a href="/mtce/delete"><input type="button" value="Delete this todo item"/></a>
{error}
