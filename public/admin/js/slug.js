const app = new Vue({
    el: '#root',
    data: {
      input: ''
    },
    computed: {
      slug: function () {
        return this.slugify(this.input)
      }
    },
    methods: {
      slugify (text, ampersand = 'and') {
        const a = 'àáäâèéëêìíïîòóöôùúüûñçßÿỳýœæŕśńṕẃǵǹḿǘẍźḧ'
        const b = 'aaaaeeeeiiiioooouuuuncsyyyoarsnpwgnmuxzh'
        const p = new RegExp(a.split('').join('|'), 'g')
        return text.toString().toLowerCase()
          .replace(/[\s_]+/g, '-')
          .replace(p, c =>
            b.charAt(a.indexOf(c)))
          .replace(/&/g, `-${ampersand}-`)
          .replace(/[^\w-]+/g, '')
          .replace(/--+/g, '-')
          .replace(/^-+|-+$/g, '')
      }
    }
});