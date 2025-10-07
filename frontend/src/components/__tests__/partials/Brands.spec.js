import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import { nextTick } from 'vue'
import { useProductStore } from '../../../stores/useProductStore'
import Brands from '../../partials/Brands.vue'

describe('Brands.vue', () => {
  it('renders brands and filters by slug', async () => {
    const pinia = createTestingPinia({ createSpy: vi.fn })
    const wrapper = mount(Brands, { global: { plugins: [pinia] } })
    const store = useProductStore()

    store.brands = [
      { id: 1, name: 'Apple', slug: 'apple' },
      { id: 2, name: 'Samsung', slug: 'samsung' },
    ]
    await nextTick()

    const btns = wrapper.findAll('button')
    expect(btns).toHaveLength(2)
    expect(btns[0].text()).toBe('Apple')

    await btns[0].trigger('click')
    expect(store.filterProducts).toHaveBeenCalledWith('brand', 'apple')
  })
})
