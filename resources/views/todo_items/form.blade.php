<head>
    <title>作業登録</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css')  }}" >
    <link rel="stylesheet" href="{{ asset('/css/style.css')  }}" >
</head>

<x-app-layout>
    <x-slot name="header">

        <div class="top">
            <a href="{{route('todo_items.create')}}">作業{{$button}}</a>
        </div>
        
        <div>ようこそ{{Auth::user()->login_id}}さん</div>

        <x-input-error class="mb-4 msg" :messages="$errors->all()"/>
        <x-message :message="session('message')"/>
    </x-slot>


    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if($type == "store")
            <form class="form" method="post" action="{{route('todo_items.'.$type)}}">
        @elseif($type == "update")
            <form class="form" method="post" action="{{route('todo_items.'.$type,$todo_item)}}">
            @method('patch')
        @elseif($type == "delete")
            <form class="form" method="post" action="{{route('todo_items.destroy',$todo_item)}}">
            @method('delete')
        @endif
        @csrf

            <div>
                <label for="item_name">項目名</label><br>
                <input class="create" type="text" name="item_name" id='item_name'
                {{ $type != "store" ? "value=".$todo_item->item_name.""  : "value=".old('item_name').""}}>
            </div>

            <div>
                <label for="user_id">担当者</label><br>
                <select class="create" name="user_id" id="user_id">
                    <option>--選択してください--</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}"
                                @if($type == "store")
                                    @if($user->id == old('user_id'))
                                        selected
                                    @endif
                                @else
                                    @if($todo_item->user_id == $user->id)
                                        selected
                                     @endif
                                @endif
                            >{{$user->name}}</option>
                        @endforeach
                </select>
            </div>
                
            <div>
                <label for="expire_date">期限</label><br>
                <input class="create" type="date" name="expire_date"
                {{ $type != "store" ? "value=".$todo_item->expire_date.""  : "value=".old('expire_date').""}}>
            </div>

            <div class="create">
                <input type="checkbox" name="finished_date" id="finished_date" value="1" 
                @if($type == "store")
                    @if(old('finished_date') == 1)
                        checked
                    @endif
                @else
                    @if($todo_item->finished_date)
                        checked
                    @endif
                @endif
                >完了
            </div>
            
            <x-primary-button>{{$button}}</x-primary-button>
            <x-cancel-button>キャンセル</x-cancel-button>
        </form>

    </div>


</x-app-layout>