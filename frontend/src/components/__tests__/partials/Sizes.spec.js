import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import { nextTick } from 'vue'
import { useProductStore } from '../../../stores/useProductStore'
import Sizes from '../../partials/Sizes.vue'

describe('Sizes.vue', () => {
  it('renders sizes and filters by id', async () => {
    const pinia = createTestingPinia({ createSpy: vi.fn })
    const wrapper = mount(Sizes, { global: { plugins: [pinia] } })
    const store = useProductStore()

    store.sizes = [
      { id: 1, name: 'S' },
      { id: 2, name: 'M' },
      { id: 3, name: 'L' },
    ]
    await nextTick()

    const btns = wrapper.findAll('button')
    expect(btns).toHaveLength(3)
    expect(btns[1].text()).toBe('M')

    await btns[2].trigger('click')
    expect(store.filterProducts).toHaveBeenCalledWith('size', 3)
  })
})
