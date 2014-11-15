<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  Enter a valid email address
</div>

<div class="bs-example">
  <legend>Creating new thread</legend>
  <div class="btn-toolbar" role="toolbar">
    <div class="form-group">
      <label for="inputSubject" class="col-lg-2 control-label">Subject</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="inputSubject" placeholder="Subject">
      </div>
    </div>
    <hr>
    <div class="form-group">
      <label class="col-lg-2 control-label"></label>
      <div class="col-lg-10">
        <div class="btn-group">
          <button type="button" class="btn btn-default" aria-label="Font"><span class="glyphicon glyphicon-font" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Bold"><span class="glyphicon glyphicon-bold" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Italic"><span class="glyphicon glyphicon-italic" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Underline"><span class="glyphicon glyphicon-magnet" aria-hidden="true"></span></button>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Center Align"><span class="glyphicon glyphicon-align-center" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Right Align"><span class="glyphicon glyphicon-align-right" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Justify"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span></button>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-default" aria-label="List"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-default" aria-label="Insert Link"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Insert Picture"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Insert Video"><span class="glyphicon glyphicon-film" aria-hidden="true"></span></button>
          <button type="button" class="btn btn-default" aria-label="Insert Attatchment"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></button>
      </div>
    </div>
    </div>
  </div>
</div>
<div class="highlight">
  <div class="form-group">
    <label for="textArea" class="col-lg-2 control-label">Message</label>
    <div class="col-lg-10">
      <textarea class="form-control" id="textArea" rows="8">Hello</textarea>
    </div>
  </div>
</div>

<style type="text/css">
.bs-example {
  margin-right: 0;
  margin-left: 0;
  background-color: #fff;
  border-color: #ddd;
  border-width: 1px;
  border-radius: 4px 4px 0 0;
  -webkit-box-shadow: none;
  box-shadow: none;
  padding: 15px;
  border-style: solid;
}
.highlight {
  padding: 15px;
  margin-bottom: 14px;
  background-color: #f7f7f9;
  border: 1px solid #e1e1e8;

  margin-top: -1px;
  margin-right: 0;
  margin-left: 0;
  border-width: 1px;
  border-bottom-right-radius: 4px;
  border-bottom-left-radius: 4px;
}
.highlight textarea {
  max-width: 100%;
  width: 100%;
}
</style>