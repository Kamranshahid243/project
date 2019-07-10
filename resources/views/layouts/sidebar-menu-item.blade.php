<a ng-href="{{'{{'}} {{$name}}.url?'/'+{{$name}}.url:'#' }}" attributes="{{'{{'}} {{$name}}.attributes }}"
   ng-click="state.toggle('{{$name}}Active', {{$name}}.title)">
    <i class="{{'{{'}} {{$name}}.class }}" ng-if="{{$name}}.class"></i>&nbsp;
    <span>
        {{'{{'}} {{$name}}.title }}
        <span ng-if="{{$name}}.child">
            <span ng-if="state.{{$name}}Active != {{$name}}.title"><i class="fas pull-right fa-caret-right"></i></span>
            <span ng-if="state.{{$name}}Active == {{$name}}.title"><i class="fas pull-right fa-caret-down"></i></span>
        </span>
    </span>
</a>