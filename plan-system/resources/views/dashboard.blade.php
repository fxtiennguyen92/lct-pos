@extends('template.index')

@push('content')
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Trang Quản trị</h4>
        </div>
    </div>

    <!-- Page content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="grid-stack" data-gs-width="12" data-gs-animate="yes">
                        <div data-gs-id="1" class="grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="4"
                            data-gs-height="2">
                            <div class="grid-stack-item-content">1</div>
                        </div>
                        <div data-gs-id="2" class="grid-stack-item" data-gs-x="4" data-gs-y="0" data-gs-width="4"
                            data-gs-height="4">
                            <div class="grid-stack-item-content">
                                <div>asdfasdf</div>
                                <span>asdfasd </span>
                            </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="8" data-gs-y="0" data-gs-width="2" data-gs-height="2"
                            data-gs-min-width="2" data-gs-no-resize="yes">
                            <div class="grid-stack-item-content"> <span class="fa fa-hand-o-up"></span> Drag me! </div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="10" data-gs-y="0" data-gs-width="2" data-gs-height="2"
                            data-gs-no-move="yes" data-gs-locked="yes">
                            <div class="grid-stack-item-content">4</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="2" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content">5</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="2" data-gs-y="2" data-gs-width="2" data-gs-height="4">
                            <div class="grid-stack-item-content">6</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="8" data-gs-y="2" data-gs-width="4" data-gs-height="2">
                            <div class="grid-stack-item-content">7</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="0" data-gs-y="4" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content">8</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="4" data-gs-y="4" data-gs-width="4" data-gs-height="2">
                            <div class="grid-stack-item-content">9</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="8" data-gs-y="4" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content">10</div>
                        </div>
                        <div class="grid-stack-item" data-gs-x="10" data-gs-y="4" data-gs-width="2" data-gs-height="2">
                            <div class="grid-stack-item-content">11</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('css')
    {{-- <link href="assets/node_modules/gridstack/gridstack.css" rel="stylesheet"> --}}
@endpush

@push('js')
    <script src="assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/node_modules/gridstack/lodash.js"></script>
    <script src="assets/node_modules/gridstack/gridstack.js"></script>
    <script src="assets/node_modules/gridstack/gridstack.jQueryUI.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.grid-stack').gridstack({
                width: 12,
                alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|mobile/i
                    .test(navigator.userAgent),
                resizable: {
                    handles: 'e, se, s, sw, w'
                },
                removable: '#trash'
            }).on('added removed change', function(e, items) {
                let str = '';
                items.forEach(function(item) {
                    str += ' (x,y,w,h)=' + item.x + ',' + item.y + ',' + item.width + ',' + item
                        .height + ',' + item.noMove + ',' + item.noResize + ',' + item.id;
                });
                console.log(e.type + ' ' + items.length + ' items:' + str);
            }).on('click', function(e) {
                let id = $(e.target).parent().attr('data-gs-x');
                if (id) {
                    console.log($(e.target).parent().attr('data-gs-x'));
                }
            });
        });
    </script>
    <script src="dist/js/custom.min.js"></script>
@endpush
