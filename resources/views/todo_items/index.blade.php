<head>
    <title>作業一覧</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}" >
    <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
</head>

<x-app-layout>
    <x-slot name="header">

        <!-- topの作業一覧の右側に検索フォームが来てほしいのであれば、この中に検索フォームを含めるようにしましょう -->
        <div class="top">
            <a href="{{route('todo_items.index')}}">作業一覧</a>
            <form method="get" action="{{route('todo_items.index')}}">
                <!-- できるだけ簡略化していきます -->
                <input type="text" name="keyword" id="keyword" value="{{$keyword}}">
                <input class="search-btn" type="submit" value="検索">
            </form>
        </div>

        <p>ようこそ<span class="name">{{Auth::user()->login_id}}</span>さん</p>
            
        <div class="search-msg">
            @if($keyword != " ")
                キーワード「{{$keyword}}」で検索
            @endif
        </div>

        <x-message :message="session('message')"/>
    </x-slot>
    
    <!-- ヘッダーのレイアウトに合わせるようにしています -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <x-create-button>作業登録</x-create-button>
        <table class="table table1">
            <tr>
                <th class="item">項目名</th>
                <th class="user-name">担当者</th>
                <th class="date">登録日</th>
                <th class="date">期限日</th>
                <th class="date">完了日</th>
                <th class="controll">操作</th>
            </tr>
            
            @foreach($todo_items as $todo_item)
                @if($todo_item->is_deleted == 0)
                    <tr>
                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete item"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger item"
                            @endif>
                            {{$todo_item->item_name}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete user-name"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger user-name"
                            @endif>
                            {{$todo_item->user->name}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete date"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger date"
                            @endif>
                            {{$todo_item->registration_date}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete date"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger date"
                            @endif>
                            {{$todo_item->expire_date}}
                        </td>

                        <td 
                            @if($todo_item->finished_date!=null)
                                class="complete date"
                            @elseif($todo_item->expire_date<date('Y-m-d'))
                                class="text-danger date"
                            @endif>
                            @if(is_null($todo_item->finished_date))
                            未
                            @else    
                            {{$todo_item->finished_date}}
                            @endif
                        </td>

                        <td class="buttons">
                            <div class="button blue">
                                <form method="post" action="{{route('complete',$todo_item)}}">
                                    @csrf
                                    <button type="submit">完了</button>
                                </form>
                            </div>
                        
                        
                            <div class="button green">
                                <button><a href="{{route('todo_items.edit',$todo_item)}}">修正</a></button>
                            </div>
                        
                            <div class="button red">
                                <button><a href="{{route('todo_items.show',$todo_item)}}">削除</a></button>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>


</x-app-layout>