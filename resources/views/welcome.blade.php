<div id="app">
    <div class="container">
        <div class="form-group">
            <label>Search</label>
            <input type="text" class="search-input" v-model="searchQuery" />
        </div>

    </div>
    <div class="container">
        <simple-grid :data-list="people" :columns="columns" :search-key="searchQuery">
        </simple-grid>
    </div>
</div>

<template id="grid-template">
    <div>
    <table>
        <thead>
        <tr>
            <th v-for="col in columns">
                @{{ col.name}}
            </th>
            <th>
                Delete
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(entry,index) in filteredData">
            <td v-for="col in columns">
                @{{entry[col.name]}}
            </td>
            <td class="text-center">
                <button @click="deleteItem(index)">delete</button>
            </td>
        </tr>
        </tbody>

    </table>
    <div class="container">
        <button class="btn" @click="openNewItemDialog('Create new item')">Create</button>
    </div>
    <modal-dialog :mode="mode" :title="title" :fields="columns" :item="item" v-on:create-item="createItem">
    </modal-dialog>
    </div>
</template>

<template id="dialog-template">
    <div class="dialogs">
        <div class="dialog" v-bind:class="{ 'dialog-active': show }">
            <div class="dialog-content">
                <header class="dialog-header">
                    <h1 class="dialog-title">@{{ title }}</h1>
                </header>

                <div v-for="field in fields" class="form-group" >
                    <label>@{{ field.name }}</label>
                    <select v-if="field.dataSource" v-model="item[field.name]">
                        <option v-for="opt in field.dataSource" :value="opt">@{{ opt }}</option>
                    </select>
                    <input v-else type="text" v-model="item[field.name]">
                </div>


                <footer class="dialog-footer">
                    <div class="form-group">
                        <label></label>
                        <button v-on:click="save">Save</button>
                        <button v-on:click="close">Close</button>
                    </div>
                </footer>
            </div>
        </div>
        <div class="dialog-overlay"></div>
    </div>
</template>


<script src="https://unpkg.com/vue"></script>
<script>
    Vue.component('simple-grid', {
        template: '#grid-template',
        props: ['dataList', 'columns', 'searchKey'],
        methods: {
            openNewItemDialog: function(title) {
                // 对话框的标题
                this.title = title
                // mode = 1表示新建模式
                this.mode = 1
                // 初始化this.item
                this.item = {}
                // 广播事件，showDialog是modal-dialog组件的一个方法，传入参数true表示显示对话框
                bus.$emit('showDialog', true)
            },
            createItem: function() {
                // 将item追加到dataList
                this.dataList.push(this.item)
                // 广播事件，传入参数false表示隐藏对话框
                this.$broadcast('showDialog', false)
                // 新建完数据后，重置item对象
                this.item = {}
            },
            deleteItem: function(index) {
                this.dataList.splice(index, 1);
            },
        },
        computed:{
            filteredData: function () {

                var filterKey = this.searchKey && this.searchKey.toLowerCase()

                var data = this.dataList
                if (filterKey) {
                    data = data.filter(function (row) {
                        return Object.keys(row).some(function (key) {
                            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                        })
                    })
                }

                return data
            }
        },
        data: function() {
            return {
                mode: 0,
                item: {},
                title: ''
            }
        },
        components: {
            'modal-dialog': {
                template: '#dialog-template',
                data: function() {
                    return {
                        // 对话框默认是不显示的
                        show: false
                    }
                },
                /*
                 * mode = 1是新增数据模式，mode = 2是修改数据模式
                 * title表示对话框的标题内容
                 * fields表示对话框要显示的数据字段数组
                 * item是由simple-dialog传下来，用于绑定表单字段的
                 */
                props: ['mode', 'title', 'fields', 'item'],
                methods: {
                    close: function() {
                        this.show = false
                    },
                    save: function() {

                    }
                }
            }
        }
    })

    var demo = new Vue({
        el: '#app',
        data: {
            searchQuery: '',
            columns: [{
                name: 'name',
                isKey: true,
            }, {
                name: 'age'
            }, {
                name: 'sex',
                dataSource:['Male','Female']
            }],
            people: [{
                name: 'Jack',
                age: 30,
                sex: 'Male'
            }, {
                name: 'Bill',
                age: 26,
                sex: 'Male'
            }, {
                name: 'Tracy',
                age: 22,
                sex: 'Female'
            }, {
                name: 'Chris',
                age: 36,
                sex: 'Male'
            }]
        }
    })
</script>