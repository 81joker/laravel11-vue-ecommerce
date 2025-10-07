import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import { nextTick } from 'vue'
import { useProductStore } from '../../../stores/useProductStore'
import Categories from '../../partials/Categories.vue'

describe('Categories.vue', () => {
  it('renders categories and calls filter on click', async () => {
    const pinia = createTestingPinia({ createSpy: vi.fn })
    const wrapper = mount(Categories, { global: { plugins: [pinia] } })
    const store = useProductStore()

    // seed state
    store.categories = [
      { id: 1, name: 'Phones', slug: 'phones' },
      { id: 2, name: 'Laptops', slug: 'laptops' },
    ]
    await nextTick()

    const buttons = wrapper.findAll('button')
    expect(buttons).toHaveLength(2)
    expect(buttons[0].text()).toBe('Phones')

    await buttons[1].trigger('click')
    expect(store.filterProducts).toHaveBeenCalledWith('category', 'laptops')
  })
})
