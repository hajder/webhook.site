<!DOCTYPE html>
<html>
<head>
    <title>Webhook Tester</title>
    <!-- Libraries -->
    <link href="assets/css/libs/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="assets/scripts/libs/jquery-2.2.2.min.js" async></script>
    <script src="assets/scripts/libs/angular.min.js"></script>


    <!-- App -->
    <script src="assets/scripts/app.js"></script>
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Pusher -->
    <script src="https://js.pusher.com/3.2/pusher.min.js"></script>

    <meta name="description" content="Easily test webhooks with this handy tool that displays requests in realtime.">
</head>
<body ng-app="app" ng-controller="AppController">

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Webhook Tester</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="nav navbar-right navbar-form">
                <div class="form-group">
                    <label for="tokenUrl" style="color: white">
                        Send webhooks to: &nbsp;
                    </label>

                    <input id="tokenUrl" type="text" class="form-control click-select"
                           style="width: 200px;"
                           value="http://{{ domain }}/{{ token.uuid }}">
                </div>
                <button class="btn btn-success" id="copyTokenUrl" data-clipboard-target="#tokenUrl">
                    <span class="glyphicon glyphicon-copy"></span> Copy</button>
                <a class="btn btn-danger" href="/#" onclick="window.location.hash = ''; window.location.reload()">
                    <span class="glyphicon glyphicon-trash"></span> New URL</a>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <p ng-show="!hasRequests" class="small">
                <img src="assets/images/loader.gif"/>
                &nbsp; Waiting for first request...
            </p>

            <ul class="nav nav-sidebar">
                <li ng-repeat="(key, value) in requests.data"
                    ng-class="currentRequestIndex === key ? 'active' : ''">
                    <a ng-click="setCurrentRequest(key)" class="prevent-default" style="cursor: pointer">
                        #{{ key }} <span class="label label-{{ getLabel(value.method) }}">{{ value.method }}</span> {{
                        value.ip }} <br/>
                        <small>{{ value.created_at }}</small>
                    </a>
                </li>
            </ul>
        </div>
        <div id="request" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div ng-show="!hasRequests">
                <p><strong>Webhook Tester</strong> allows you to easily test webhooks and other types of HTTP requests.</p>
                <p>Here's your unique URL:</p>
                <p>
                    <code>http://{{ domain }}/{{ token.uuid }}</code>
                    <a href="http://{{ domain }}/{{ token.uuid }}" target="_blank">(try it!)</a>
                </p>
                <p>Any requests sent to that URL are instantly logged here - you don't even have to refresh.</p>
                <p>You can bookmark this page to go back to the request contents at any time.</p>
            </div>
            <div class="table-responsive" ng-show="hasRequests">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td style="width:100px;"><b>URL</b></td>
                        <td id="req-url">{{ currentRequest.url }}</td>
                    </tr>
                    <tr>
                        <td><b>IP/Host</b></td>
                        <td id="req-ip">{{ currentRequest.hostname }} ({{ currentRequest.ip }})</td>
                    </tr>
                    <tr>
                        <td><b>Headers</b></td>
                        <td colspan="2" id="req-headers">
                            <span ng-repeat="(headerName, values) in currentRequest.headers">
                                <strong>{{ headerName }}:</strong>
                                <code ng-repeat="value in values">{{ (value == '' ? '(empty)' : value) }}{{$last ? '' : ', '}}</code>
                                <br/>
                            </span>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <p ng-show="hasRequests && currentRequest.content == ''">The request did not have any body content.</p>
                <pre id="req-content" ng-show="hasRequests && currentRequest.content != ''">
{{ currentRequest.content }}
</pre>

            </div>
        </div>
    </div>
</div>
<script src="assets/scripts/libs/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous" async defer></script>
<script src="assets/scripts/libs/clipboard.min.js"></script>

</body>
</html>
